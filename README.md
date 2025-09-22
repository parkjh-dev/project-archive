# 학군단 동기회 관리 시스템 (V1, 1인 개발)

<img width="1430" height="944" alt="Image" src="https://github.com/user-attachments/assets/c2232652-605f-4118-a60e-4e87765d4136" />

<img width="260" height="179" alt="Image" src="https://github.com/user-attachments/assets/3b87f915-61bd-4130-b486-4fd7e6be1890" />

## Abstract
- 학군단 동기회에서 발송하는 SMS(회비 납부 독려, 생일, 경조사, 기념일, 명절 등)를 자동화하여 발 송하는 서비스를 개발함.

## Function
- 매일 09시, FaaS에 등록된 Python Code를 실행하여 SMS을 발송해야 하는 이벤트가 있는 지 확인함.
- 발송해야 하는 이벤트가 있다면 CSV 파일에서 대상자의 이름과 전화번호를 가져옴.
- NCP의 Simple & Easy Notification Service 를 이용하여 SMS를 발송함.
- 그외동기회멤버의경조사문자를발송함.(수동)

## Tech
- Code : Python
- FaaS : Cloud Functions (Naver Cloud)
- SMS : Simple & Easy Notification Service

## Note
- 아래 사유로 해당 서비스(V1)를 종료하고 V2 버전을 개발함.
- Simple&EasyNotificationService서비스종료
- WebService운영
- 관리자외사용자문자발송시스템,이미지게시판,회비납부회계기능추가

## State
- Retired
