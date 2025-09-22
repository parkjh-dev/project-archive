import pymysql #설치 필요
import re
from datetime import datetime
import sys,os
sys.path.append("/project/lib")
from filter_log import log_write

# 로그 객체 생성    
logs = log_write("/project/filter_update/mecab/log/")

# 프로그램 실행 시 파라미터로 대상을 입력(military_filter, request_filter)
if(sys.argv[1] != "military_filter" and sys.argv[1] != "request_filter"):
    print()
    print("No parameter or an invalid value was passed.....")
    print("ex. $python3 add-dic.py military_filter or $python3 add-dic.py request_filter")
    exit(-1)

target_name = sys.argv[1]

#DB 연결
try:
    mydb = pymysql.connect(user='root',password='xhdgkfk19!',host='127.0.0.1',port=3307,db='contest')
    mydbconn = mydb.cursor()
    logs.logging('+','Data Base: Connection Success')
except:
    logs.logging('-','Data Base: Connection Fail')
    exit(-1)

# 필터 테이블의 prohibit 컬럼 정보를 오름차순으로 모두 가져오기
sql = 'SELECT prohibit FROM '+target_name+' ORDER BY prohibit'
mydbconn.execute(sql)
sql_result = mydbconn.fetchall()
logs.logging("+","prohibit data load")

backup_name = datetime.today().strftime('%Y%m%d')+"_"+target_name+"_"+"bak"

#csv 파일 생성
data = open("/root/mecab-ko-dic-2.0.1-20150920/user-dic/"+target_name+".csv",'w')
backup = open("/project/filter_update/mecab/csv_backup/"+backup_name+".csv",'w')
logs.logging("+","CSV File Open")


for i in sql_result:
    word_str = ''.join(i)
    word_str = word_str.replace(" ","") # 단어의 앞 공백 제거
    if re.subn(r"^[0-9]","",word_str)[1] == 1: # 첫글자가 숫자로 시작하면 추가 생략
        continue
    data.write(word_str+",,,,NNP,*,F,"+word_str+",*,*,*,*"+"\n")
    backup.write(word_str+",,,,NNP,*,F,"+word_str+",*,*,*,*"+"\n")
logs.logging("+","Add to Data")

# csv 파일 닫기
data.close()
backup.close()
logs.logging("+","CSV File Close")

'''
# tools/add-userdic.sh 실행
os.system("~/mecab-ko-dic-2.0.1-20150920/tools/add-userdic.sh")



# make install
os.system("make install")
'''