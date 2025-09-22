import csv
import pymysql #설치 필요
from datetime import datetime

# default 파일 읽기
data = open("request_filter_default.csv",'r',encoding='utf-8')
rdr = csv.reader(data)

mydb = pymysql.connect(user='root',password='xhdgkfk19!',host='127.0.0.1',port=3307,db='contest')
mydbconn = mydb.cursor()

# request_filter 테이블 내 모든 내용 삭제
mydbconn.execute("TRUNCATE request_filter")

data_count = 0 # 추가된 총 데이터 개수

# 라인을 읽어서 DB에 insert
for line in rdr:
    sql = 'INSERT INTO request_filter(word,prohibit,value) VALUES("'+line[1]+'","'+line[0]+'","'+line[2]+'")'
    mydbconn.execute(sql)
    data_count += 1

# conf 필터 개수 수정
conf_value = datetime.today().strftime('%Y%m%d') +','+str(data_count)
conf_sql = 'UPDATE conf SET value = "'+conf_value+'" WHERE name = "request_filter_version"'
mydbconn.execute(conf_sql)


mydb.commit()
data.close()   