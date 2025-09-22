import csv # pip3 install 
import datetime
from pytz import timezone # pip3 install
import json
import requests
import time
import base64
import hashlib
import hmac
import authentication # user module

class RotcSms:
    def __init__(self):
        self.today = '' # 오늘 날짜
        self.member = [] # 회원 정보
        self.target = [] # 발송 대상
        self.message = '' # 발송 메세지

        self.timestamp = str(int(time.time() * 1000))
        self.user_access_key = ''
        self.user_secret_key = ''
        self.sms_service_id = ''
        self.url = ''
        self.api_url = ''

        self.headers = {} # HTTP HEADER
        self.body = {} # HTTP BODY

        day = datetime.datetime.now(timezone('Asia/Seoul'))
        self.today = day.strftime("%y")+day.strftime("%m")+day.strftime("%d")

        f_csv = open('./member.csv', 'r', encoding='utf-8')
        read = csv.reader(f_csv)
        for line in read:
            self.member.append({'name': line[0],'phone': line[1], 'birth':line[2]})
        f_csv.close()
    
    # 발송 대상자 정보 획득
    def get_target(self):
        return self.target

    # message 데이터 획득
    def get_message(self):
        return self.message

    # HMAC 암호화 알고리즘은 HmacSHA256 사용
    def make_signature(self,url,access_key,user_secret_key):
        method = "POST"
        message = method + " " + url + "\n" + self.timestamp + "\n" + access_key
        message = bytes(message,'UTF-8')
        signingkey = base64.b64encode(hmac.new(user_secret_key,message, digestmod=hashlib.sha256).digest())
        return signingkey

    # Naver Cloud SMS Service 이용 준비
    def sms_init(self,target, message):
        self.user_access_key = authentication.get_access_key() # 사용자 access-key
        self.user_secret_key = authentication.get_secret_key() # 사용자 비밀키
        self.user_secret_key = bytes(self.user_secret_key,'UTF-8')
        self.sms_service_id = authentication.get_service_id() # sms 서비스 id

        self.url = "/sms/v2/services/"+self.sms_service_id+"/messages" # 사용자 서명을 위한 URL
        self.api_url = 'https://sens.apigw.ntruss.com/sms/v2/services/'+self.sms_service_id+'/messages' #requests를 위한 full URL

        # 헤더 값
        self.headers = {
            'Content-Type': 'application/json; charset=utf-8',
            'x-ncp-apigw-timestamp': self.timestamp,
            'x-ncp-iam-access-key': self.user_access_key,
            'x-ncp-apigw-signature-v2': self.make_signature(self.url,self.user_access_key,self.user_secret_key)
        }
        # body(data) 값
        self.body = {
            "type" : "MMS",
            "contentType" : "COMM",
            "countryCode" : "82",
            "from" : authentication.get_sender(),
            "content" : message % (target['name']),
            "messages" : [{
                    "to":target['phone'],
            }]
        }

    # sms 전송
    def sms_send(self, target, message):
        self.sms_init(target,message)
        body_result = json.dumps(self.body)
        response = requests.post(self.api_url,headers=self.headers,data=body_result)
        response.request
        response.status_code
        response.raise_for_status()
        response_result = response.json()
        send_result = response_result['statusCode']

        # 발송 결과 출력
        if send_result == "202":
            print("[SMS] : Sending Success")
        else:
            print("[SMS] : Sending Fail")

    # 생일 축하 문자
    def birth_chk(self): 
        today=self.today[2:6] # 오늘 날짜 (월/일)
        # 대상자 추가
        for i in self.member:
            if (today == i['birth'][2:6]): 
                self.target.append(i)
        # 발송 문자 로드
        txt = open('./txt/birth.txt', 'r', encoding='utf-8')
        self.message = txt.read()
        txt.close()
    
    # 입단/임관 기념일 문자
    def commission_chk(self):
        today=self.today[2:6] # 오늘 날짜 (월/일)
        month=self.today[2:4] # 오늘 날짜 (월)
        
        if(today == '0301'):
            txt = open('./txt/commission.txt', 'r', encoding='utf-8')
            self.message = txt.read() % ('%s',month, month)
            txt.close()
            for i in self.member:
                self.target.append(i)

    # 신년 문자
    def new_year_chk(self):
        today=self.today[2:6] # 오늘 날짜 (월/일)
        month=self.today[2:4] # 오늘 날짜 (월)

        if(today == '0101'):
            txt = open('./txt/new_year.txt', 'r', encoding='utf-8')
            self.message = txt.read() % ('%s')
            print(self.message)
            txt.close()
            for i in self.member:
                self.target.append(i)

    # 회비 납부 문자
    def dues_chk(self):
        month=self.today[2:4] # 오늘 날짜 (월)
        day=self.today[4:6] # 오늘 날짜 (일)
        
        # 현재 날짜가 10일이면 동기회 문자 문구 불러오기
        if(day == '10'):
            txt = open('./txt/dues.txt', 'r', encoding='utf-8')
            self.message = txt.read() % ('%s',month, month)
            txt.close()
            for i in self.member:
                self.target.append(i)

    # 수동 발송
    def manual_mode(self,message):
        self.message = message
        for i in self.member:
            self.target.append(i)
                
    # Debug
    '''
    def Print(self):
        print(self.today)
        print(self.member)
        print(self.target)
        print(self.message)
        print(self.timestamp)
        print(self.headers)
        print(self.body)
        print('---------------------')
    '''  
'''
    def __del__(self):
        print('END Program')
'''
