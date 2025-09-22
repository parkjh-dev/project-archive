import RotcSms

def main(args):
    if (args.get("message")):
        # 수동 입력
        manual = RotcSms.RotcSms()
        manual.manual_mode(args.get("message"))
        message = manual.get_message()
        target = manual.get_target()
        
        for i in target:
            manual.sms_send(i,message)
        
        return {"message":args.get("message"), "mode":"manual","result": "Done"}
    else:    
        # 신년
        new_year = RotcSms.RotcSms()
        new_year.new_year_chk()

        message = new_year.get_message()
        target = new_year.get_target()

        if target:
            for i in target:
                new_year.sms_send(i,message)
        #
            
        # 임관 / 입단 기념일
        commission = RotcSms.RotcSms()
        commission.commission_chk()

        message = commission.get_message()
        target = commission.get_target()

        if target:
            for i in target:
                commission.sms_send(i,message) 
        #
        
        # 생일
        birth = RotcSms.RotcSms()
        birth.birth_chk()

        message = birth.get_message()
        target = birth.get_target()

        if target:
            for i in target:
                birth.sms_send(i,message)
        #
        
        # 회비
        dues = RotcSms.RotcSms()
        dues.dues_chk()

        message = dues.get_message()
        target = dues.get_target()

        if target:
            for i in target:
                dues.sms_send(i,message)
        #
        
        return {"mode":"auto","result": "Done"}
    