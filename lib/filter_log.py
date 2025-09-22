from datetime import datetime
import sys,os
import getpass

class log_write:
    log = None
    log_name = '' # 로그파일 이름
    system_name = '' # 작업하는 사용자
    today = ''# 작업 날짜 (%Y-%m-%d %H:%M:%S 포맷)
    
    def __init__(self,dir):
        # 로그파일 생성 (성공: +, 에러: *,  실패: - )
        try:
            log_write.log_name = datetime.today().strftime('%Y%m%d')
            log_write.system_name = getpass.getuser()
            log_write.today = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
            log_write.log = open(dir+log_write.log_name+'.txt','a+')
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
