'''
****************************************************************************
  @ Name: korean_filter_update.py
  @ Author: PARK JI HWAN
  @ Date: 2022. 07. 27.
  @ Update: None
  @ Comment: 국립국어원 우리말샘 데이터를 이용하여 필터 업데이터
*****************************************************************************
'''
import os
import shutil
import json
from datetime import datetime
import chardet # 설치 필요
import re
import getpass
import pymysql #설치 필요

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
            log_write.log_name = datetime.today().strftime('%Y%m%d')
            log_write.system_name = getpass.getuser()
            log_write.today = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
            log_write.log = open("/project/filter_update/korean/log/"+log_write.log_name+'.txt','a+')
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

# 로그 객체 생성    
logs = log_write()
#

update_dir = '/project/filter_update/korean/update/'
backup_dir = '/project/filter_update/korean/backup/'

update_file_list = os.listdir(update_dir) # 디렉터리 파일 리스트
update_dir_count = len(update_file_list) # 디렉터리 파일 개수

# 업데이트 파일 갯수에 따른 파일 실행유무 결정
if(update_dir_count == 0):
    logs.logging('-','File Load: There is no update file')
    exit(-1)
if(update_dir_count > 2):
    logs.logging('-','File Load: There are many files')
    exit(-1)
else:
    logs.logging('+','File Load: Load Success')

# 불러온 데이터 저장하는 리스트
data_set = list()
#

# 데이터 분석
try:
    for i in update_file_list:
        # json file open
        try:
            with open(update_dir+i, 'r', encoding='utf-8') as f:
                json_data = json.load(f)
            logs.logging('+','File Open : ['+i+'] Success')
        except:
            logs.logging('+','File Open : ['+i+'] Fail')
            exit(-1)

        data_count = len(json_data['channel']['item'])

        pattern = "\‘([^’]+)" # 금칙어를 분리할 정규식

        # 추출 데이터 가공 후 list에 저장
        for j in range(0,data_count):
            value = json_data['channel']['item'][j]['senseinfo']['definition']
            prohibit = json_data['channel']['item'][j]['wordinfo']['word']
            prohibit = prohibit.replace('-','') # 금칙어 내 하이픈 제거
            word = re.findall(pattern,value)
            
            if (word != None and len(word) != 0 and len(prohibit) > 1):
                word = word[0]
                data_set.append([word,prohibit,value])
        f.close()

        # update -> backup 디렉터리 이동 
        try:
            shutil.move(update_dir+str(i), backup_dir+str(i)) 
            logs.logging('+','File Backup: ['+i+'] Backup Success') 
        except:
            logs.logging('-','File Backup: ['+i+'] Backup Fail')
        logs.logging('+','File Analysis : ['+i+'] Analysis Success')
except:
    logs.logging('-','File Analysis : ['+i+'] Analysis Fail')
#

# 추출한 데이터 수
updata_sum = len(data_set)

# DB 연결 (db명: contest, 테이블명: military_filter, 컬럼: word, prohibit)
try:
    mydb = pymysql.connect(user='root',password='xhdgkfk19!',host='127.0.0.1',port=3307,db='contest')
    mydbconn = mydb.cursor()
    logs.logging('+','Data Base: Connection Success')
except:
    logs.logging('-','Data Base: Connection Fail')
    exit(-1)
#

# military_filter 테이블 내 모든 내용 삭제
mydbconn.execute("TRUNCATE korean_filter")
mydb.commit()

# 데이터 삽입 sql
data_sql = "INSERT INTO korean_filter(word,prohibit,value) VALUES(%s,%s,%s)"

# 데이터 삽입
mydbconn.executemany(data_sql,data_set)
logs.logging('+','Data Insert : '+str(mydbconn.rowcount)+' Success') # 완료 개수 로깅

# 필터버전 및 필터 수 conf db에 삽입 추가 
conf_value = datetime.today().strftime('%Y%m%d') +','+str(mydbconn.rowcount)

version_chk = mydbconn.execute('select * from conf where name = "korean_filter_version"')

# conf 테이블 필터정보 존재에 따른 sql 구분
if(version_chk == 0):
    conf_sql = 'INSERT INTO conf(name,value) VALUES("korean_filter_version","'+conf_value+'")'
else:
    conf_sql = 'UPDATE conf SET value = "'+conf_value+'" WHERE name = "korean_filter_version"'

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
logs.log_close()
exit(0)

# exit 0: 정상종료 / -1: 에러 / 1: 업데이트 불필요