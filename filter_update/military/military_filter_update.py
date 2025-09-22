'''
****************************************************************************
  @ Name: military_filter_update.py
  @ Author: PARK JI HWAN
  @ Date: 2022. 07. 27.
  @ Update: None
  @ Comment: military_filter_update
*****************************************************************************
'''

import pandas as pd # 설치 필요
import chardet # 설치 필요
from requests import get # 설치 필요
import pymysql #설치 필요
from datetime import datetime
import getpass
import os

global file_name # 다운로드 받은 파일(데이터) 이름


'''
@ Class: log_write 
@ __init__: 로그파일 생성
@ __del__: 로그파일 종료
@ logging: print로그와 파일로그를 남기는 함수 Parameter(log_type:로그 유형, log_str:로그 문구), return(None)
@ Comment: 로그파일을 생성 및 소멸하고 print로그와 파일로그를 남기는 클래스
'''   
class log_write:
    log = None
    log_name = '' # 로그파일 이름
    system_name = '' # 작업하는 사용자
    today = ''# 작업 날짜 (%Y-%m-%d %H:%M:%S 포맷)
    
    def __init__(self):
        # 로그파일 생성 (성공: +, 에러: *,  실패: - )
        try: 
            log_write.log_name= datetime.today().strftime('%Y%m%d')
            log_write.system_name = getpass.getuser()
            log_write.today = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
            log_write.log = open("/project/filter_update/military/log/"+log_write.log_name+'.txt','a+')
            print('+Log File : ['+log_write.log_name+'] Open')
        except:
            print('-Log File : ['+log_write.log_name+'] Not Open')

    def logging(self,log_type,log_str):
        print(log_type+log_str) # print 로그
        log_write.log.write(log_write.today+'\t'+log_write.system_name+'\t'+log_type+log_str+'\n') # 파일 로그
        
    def log_close(self):
        try:
            log_write.log.close()
            print('+Log File : ['+log_write.log_name+'] Close')
        except:
            print('-Log File : ['+log_write.log_name+'] Not Close')
#


'''
@ Function: download 
@ Parameter(str): url(파일 다운로드 링크) 
@ Return(int): 200 = 정상, .-1 : 업데이트 미실시 -1
@ Comment: 필터 데이터를 다운로드 받는 함수
'''   
def download(url):
    global file_name
    response = get(url)# get request
    data = response.headers['Content-Disposition']
    index = data.find(".csv")
    version = data[index-8:index]
    file_name = "military_data_"+version+".csv"
    
    # 디렉터리에 내려받은 파일이 있으면 새로 저장하지 않고 종료
    dir_list = os.listdir("/project/filter_update/military/data/")
    if file_name in dir_list:
        return -1
        
    try:
        f = open("/project/filter_update/military/data/"+file_name, "wb")  # open in binary mode
    except:
        print('-File open : ['+file_name+'] Fail')  

    f.write(response.content)      # write to file
    f.close()
    return response.status_code # 상태 반환
#

# 로그 객체 생성    
logs = log_write()

# 국방데이터 다운로드 URL
download_url="https://www.data.go.kr/cmm/cmm/fileDownload.do?atchFileId=FILE_000000002489327&fileDetailSn=1&insertDataPrcus=N"

if (download(download_url) == -1):
    logs.logging('-','Download File : ['+file_name+'] No need to Update')
    exit(1)
else:
    logs.logging('+','Download File : ['+file_name+'] Success')
#

pd.set_option('display.max_columns', None) # 모든 열을 출력

# 국방데이터 파일명
military_data_name = "/project/filter_update/military/data/"+file_name

# 파일 인코딩 확인
try:
    rawdata = open(military_data_name, 'rb').read()
    result = chardet.detect(rawdata)
    charenc = result['encoding']
    logs.logging('+','File Encoding : ['+military_data_name+'] Success')
except:
    logs.logging('-','File Encoding : ['+military_data_name+'] Fail')
    exit(-1)
#    

# 파일 오픈
try:
    military_data= pd.read_csv(military_data_name, encoding = charenc)
    logs.logging('+','File open : ['+military_data_name+'] Success')
except:
    logs.logging('-','File open : ['+military_data_name+'] Fail')
    exit(-1)
#

null_filter = military_data[military_data["금칙어"].notnull()] # 빈칸 내용 제거
result = null_filter[["단어 명","금칙어"]] # 2개의 컬럼만 추출

# 데이터 분석 결과
if(result is not None):
    logs.logging('+','File Analysis : ['+military_data_name+'] Success')
else:
    logs.logging('-','File Analysis : ['+military_data_name+'] Fail')
    exit(-1)
#

#### 인덱스 사용법 result['금칙어'][35] ####

# 데이터 리스트 출력
print("\nDownload Data List: ")
print(result+'\n')
#

data_count = len(result.index) # 총 row 수

data_list = result.values.tolist() #list로 변환

# 금칙어 분리 (, 구분자로 분리)
input_data = list()
for i in range(data_count):
    split_data = data_list[i][1].split(',')
    if(len(split_data) == 1):
        a = 1
        input_data.append(data_list[i])
    else:
        for s in range(len(split_data)):
            input_data.append([data_list[i][0],split_data[s]])
#          
    




# DB 연결 (db명: contest, 테이블명: military_filter, 컬럼: word, prohibit)
try:
    mydb = pymysql.connect(user='root',password='xhdgkfk19!',host='127.0.0.1',port=3307,db='contest')
    mydbconn = mydb.cursor()
    logs.logging('+','Data Base: Connection Success')
except:
    logs.logging('-','Data Base: Connection Fail')
    exit(-1)

# military_filter 테이블 내 모든 내용 삭제
mydbconn.execute("TRUNCATE military_filter")
mydb.commit()


# 데이터 삽입 sql
data_sql = "INSERT INTO military_filter(word,prohibit) VALUES(%s,%s)"

# 데이터 삽입
mydbconn.executemany(data_sql,input_data)
logs.logging('+','Data Insert : '+str(mydbconn.rowcount)+' Success') # 완료 개수 로깅

# 필터버전 및필터 수 conf db에 삽입 추가 
conf_value = datetime.today().strftime('%Y%m%d') +','+str(mydbconn.rowcount)

version_chk = mydbconn.execute('select * from conf where name = "military_filter_version"')

if(version_chk == 0):
    conf_sql = 'INSERT INTO conf(name,value) VALUES("military_filter_version","'+conf_value+'")'
else:
    conf_sql = 'UPDATE conf SET value = "'+conf_value+'" WHERE name = "military_filter_version"'
mydbconn.execute(conf_sql)

mydb.commit()



# DB 연결 해제
try:
    mydb.close()
    logs.logging('+','Data Base: Disconnect Success')
except:
    logs.logging('-','Data Base: Disconnect Fail')
    exit(-1)

# 로그 소멸 및 s/w 종료
log.log_close()
exit(0)


# exit 0: 정상종료 / -1: 에러 / 1: 업데이트 불필요




