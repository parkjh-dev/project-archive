<?php
     require "lib/top.php";
?>
<h3>소개</h3><hr/>

<p><h5>1. 서비스 소개</h5><br></p>

<div style="color:#6e6e6e; width:80%;">
    &nbsp;국방단어 교정체계는 2022 국방부 공공데이터 활용 경진대회 '통하라 그리고 통했다'팀의 출품작입니다.<br>
    <br>
    &nbsp;본 체계는 대회 취지에 맞게 '국방부_국방데이터 표준단어 목록'과 '문화체육관광부 국립국어원_개방형 사전(우리말샘)'의 공공데이터를 기반으로 개발되었으며,군에서 작성되는 문서 용어의 표준어 사용을 통한 표준화 달성의 목표를 갖고 있습니다.<br>
    <br>
    &nbsp;문서의 표준화 검사를 위해 사용자가 직접 문자열을 입력하여 확인하는 <a href='/str_correction/str_correction.php'><b>[문장검사]</b></a> 기능과 사용자가 hwp,txt 파일을 업로드하여 확인하는 <a href='/file_correction/file_correction.php'><b>[파일검사]</b></a> 기능이 있으며,
    각 기능에서 사용하는 필터는 국방API를 활용한 '국방부 필터'와 국어원API의 지역 방언을 검색한 '국어원 필터', 사용자가 관리자에게 <a href='/request_word/request_word.php'><b>[단어추가요청]</b></a> 기능을 통해 요청하여 등록된 '관리자 필터'가 있습니다.
    국방부 필터와 국어원 필터는 매주 일요일 자정에 새로운 업데이트 자료가 있다면 업데이트를 자동으로 수행하며, 필터링 단어 확인은 <a href='/filter_search/filter_search.php'><b>[필터검색]</b></a> 기능을 통해 확인할 수 있습니다..<br>
    <br>
    &nbsp;<a href='/document_security/document_security.php'><b>[문서보안]</b></a> 기능은 부가기능으로 문서의 해시값을 확인하여 사용자간의 무결성을 검증하는 해시 추출기능과 대칭키 기반의 AES알고리즘을 이용한 파일 암호화 기능을 통해 그림, 텍스트파일 등 암호화가 되지 않는 문서와 더불어 더욱 보안성 있는 전송 및 보관을 통해 데이터 기밀성을 유지할 수 있습니다.<br>
</div>
    <br><br><hr>

<p><h5>2. 기능 소개</h5><br></p>    
<div>
    <div style="color:#6e6e6e; width:80%;">
        <p><a href='/str_correction/str_correction.php'><b>[문장검사]</b></a></p></p>
        <p>
            &nbsp;문장검사 가능은 사용자가 500자 이내의 문자열을 입력하여 3가지 필터(국방부, 국어원, 관리자)중 사용자가 원하는 필터를 적용하여 검사를 수행하는 기능입니다. 각 필터는 아래의 특징을 갖고 있습니다.
            <br><br>
            <p>
                - <b>국방부 필터</b>: '국방부_국방데이터 표준단어 목록' API를 이용한 필터입니다. 군 조직 특성에 맞는 단어가 포함되어 있어 매우 신뢰성 있는 필터입니다. 해당 필터를 참고하여 표준에 맞는 단어를 사용할 수 있도록 할 수 있습니다.<br>
            </p>
            <p>
                - <b>국어원 필터</b>: '문화체육관광부 국립국어원_개방형 사전(우리말샘)' API를 이용한 필터입니다. 현재 국어사전에 등재된 항목 중 방언만 사용 가능합니다. 정상적인 단어도 오판 될 수 있으니 결과의 내용을 참고하여 사용하시길 바랍니다.<br>
            </p>
            <p>
                - <b>관리자 필터</b>: 사용자가 요청하고 관리자가 승인한 단어가 포함된 필터입니다. 국방부 필터와 더불어 조직에 특성에 맞는 단어가 포함되어 있어 신뢰성 있는 필터입니다.<br>
            </p>
        </p>
        <center><img src = "/res/str_correction_page.png"  style="margin: 0;"/></center>  
    </div>

    <div style="color:#6e6e6e; width:80%;">
        <p><a href='/file_correction/file_correction.php'><b>[파일검사]</b></a></p>
        <p>
            &nbsp;파일검사 기능은 사용자가 작성한 파일을 업로드하여 3가지 필터(국방부, 국어원, 관리자)중 사용자가 원하는 필터를 적용하여 검사를 수행하는 기능입니다. 현재 확장자는 txt, hwp만 지원하고 파일이름은 특수문자가 포함되지 않은 영문만 지원하므로 참고하시길 바랍니다. hwp 파일의 표에 포함된 문자열을 포함되지 않으며 결과출력까지 약 20초의 시간이 지연될 수 있습니다. 각 필터는 아래의 특징을 갖고 있습니다.

            <br><br>
            <p>
                - <b>국방부 필터</b>: '국방부_국방데이터 표준단어 목록' API를 이용한 필터입니다. 군 조직 특성에 맞는 단어가 포함되어 있어 매우 신뢰성 있는 필터입니다. 해당 필터를 참고하여 표준에 맞는 단어를 사용할 수 있도록 할 수 있습니다.<br>
            </p>
            <p>
                - <b>국어원 필터</b>: '문화체육관광부 국립국어원_개방형 사전(우리말샘)' API를 이용한 필터입니다. 현재 국어사전에 등재된 항목 중 방언만 사용 가능합니다. 정상적인 단어도 오판 될 수 있으니 결과의 내용을 참고하여 사용하시길 바랍니다.<br>
            </p>
            <p>
                - <b>관리자 필터</b>: 사용자가 요청하고 관리자가 승인한 단어가 포함된 필터입니다. 국방부 필터와 더불어 조직에 특성에 맞는 단어가 포함되어 있어 신뢰성 있는 필터입니다.<br>
            </p>
        </p>
        <center>
        <table>
            <tr>
                <td>
                    <img src = "/res/file_correction_page0.png"  style="margin: 0; width:100%;"/>
                </td>
                <td>
                    <img src = "/res/file_correction_page1.png"  style="margin: 0; width:100%;"/>
                </td>    
            </tr>
        </table>
        </center>
        <br><br>
    </div>

    <div style="color:#6e6e6e; width:80%;">
        <p><a href='/filter_search/filter_search.php'> <b>[필터검색]</b></a></p>
        <p>
            &nbsp;필터검색 기능은 현재 체계의 3가지 필터(국방부, 국어원, 관리자)에 대해서 분류(금칙어, 교정어, 내용)에 따른 검색을 하는 기능입니다. 국방부 필터의 내용값는 비어 있습니다. 
        </p>
        <center><img src = "/res/filter_search_page.png"  style="margin: 0;"/></center>
    </div>

    <div style="color:#6e6e6e; width:80%;">
        <p><a href='/document_security/document_security.php'><b>[문서보안]</b></a></p>
        <p>
            &nbsp;문서보안 기능은 부가기능으로 파일의 해시값을 확인하여 데이터의 무결성을 검증하고, 공개키 방식의 AES 알고리즘을 이용하여 생성한 키와 패스워드를 이용하여 파일을 암/복호화 할 수 있습니다. 해시와 암호화 기능은 아래와 같습니다. 
        </p>
        <p>
            <h6><b>- 해시</b></h6>
            1. 파일의 발송자는 해당 기능을 이용하여 파일을 업로드하고 원하는 해시(체크섬)를 확인합니다.<br>
            2. 파일의 발송자는 발송하는 파일과 더불어 해시 결과값도 전송합니다.<br>
            3. 파일의 수신자는 발송자로부터 파일을 수신받고 무결성을 확인하기 위해 해당 체계를 이용하여 다시 파일의 해시값(체크섬)을 확인합니다.<br>
            4. 발송자가 알려준 해시와 수신자가 확인한 해시가 일치한다면 해당 파일은 통신과정에서 위/변조가 이뤄지지 않은 무결한 상태임을 검증합니다.<br>
            <center><br># 한글 / 특수문자로 이뤄진 파일은 지원하지 않습니다.<br> </center>
            <center><img src = "/res/hash_page.png"  style="margin: 0;"/></center>
        </p>
        <br><br>
        <p>
            <h6><b>- 문서 암/복호화</b></h6>
            &nbsp; 문서 암/복호화 기능은 공개키 방식으로 암/복호화에 사용되는 키가 같습니다. 파일을 잠구는 기능으로 기존의 압축, 오피스 S/W 비밀번호로 접근을 제한하는 기능이 있지만 비밀번호를 누구나 아는 사람이라면 데이터에 접근할 수 있다는 단점이 존재합니다.<br>
            본 기능의 장점은 비밀번호를 알고 있더라도 해당 키 파일이 없다면 파일을 암/복호화 할 수 없기 때문에 데이터의 기밀성을 보장할 수 있습니다.<br><br>
            1. 사용자는 조직의 파일을 암호화하기 위해 비밀번호가 포함된 키 생성 기능을 이용하여 고유 키를 생성합니다.<br>
            2. 생성된 키를 이용하여 이미지 파일(png)와 키 파일 비밀번호를 입력하여 암호화를 수행합니다.<br>
            3. 이후 키는 쉽게 접근하지 못하는 폴더 또는 저장매체에 보관합니다.<br>
            4. 사용자는 해당 파일을 열람하기 위해 다시 체계에 접속하여 키파일과 비밀번호, 암호화된 파일을 업로드하여 복호화하여 데이터에 접근합니다.<br>
            <center><br># 한글 / 특수문자로 이뤄진 파일은 지원하지 않습니다.<br> </center>
            <center><img src = "/res/key_page.png"  style="margin: 0;"/></center>
            <center><img src = "/res/enc_page.png"  style="margin: 0;"/></center>
        </p>
    </div>
    <br><br>
    <div style="color:#6e6e6e; width:80%;">
        <p><a href='/request_word/request_word.php'><b>[단어 추가요청]</b></a></p>
        <p>
            &nbsp;단어 추가요청 기능은 사용자가 본 체계에 추가되었으면 하는 금칙어에 대한 교정어를 관리자에게 요청하는 기능합니다. 관리자는 별도의 페이지를 통해 사용자가 요청한 필터에 대해 추가하여 모든 사용자가 해당 금칙어로 필터링 할 수 있습니다.
        </p>
        <center><img src = "/res/request_word_page.png"  style="margin: 0;"/></center>
    </div>

    <div style="color:#6e6e6e; width:80%;">
        <p><a href='#'><b>[관리자페이지]</b></a></p>
        <p>
            &nbsp;관리자페이지 기능은 사용자가 단어추가요청 기능을 통해 요청한 단어를 추가 / 제거하는 기능입니다. 해당 페이지에 접근하기 위해서는 특정 URL 및 계정을 갖고 있어야 하며, 해당 정보를 별도 문서에 첨부 하였습니다.<br>
            
        </p>
        <center><img src = "/res/admin_page.png"  style="margin: 0;"/></center>
    </div>
</div>
<br><br><hr>

<h5>3. 서비스 문의</h5><br>
<div style="color:#6e6e6e; width:80%;">
   <p>2022 국방부 공공데이터 활용 경진대회 '통하라그리고통했다' Team</p>
   <p></p>
</div>

<table style="width:70%;">
    <tr>
        <td>
            <table style="width:80%;">
                <tr>   
                    <td><b>[팀장]</b></td>
                </tr>
                
                <tr>
                    <td rowspan="5"><img src = "/res/park.png"  style="margin: 0; width:150px;"/></td> 
                    <td>Name</td> 
                    <td>박지환</td>
                </tr>

                <tr>
                    <td>Phone</td> 
                    <td>010-3499-1929</td>
                </tr>

                <tr>
                    <td>E-mail</td> 
                    <td>parkjh@jiran.com</td>
                </tr>

                <tr>
                    <td>Blog</td> 
                    <td>https://blog.greatpark.co.kr</td>
                </tr>

                <tr>
                    <td>Github</td>  
                    <td>https://github.com/GreatPark96</td>
                </tr>
            </table>
        </td>

        <td>
            <table style="width:80%;">
                <tr>   
                    <td><b>[팀원]</b></td>
                </tr>
                
                <tr>
                    <td rowspan="5"><img src = "/res/yang.jpeg"  style="margin: 0; width:150px;"/></td> 
                    <td>Name</td> 
                    <td>대위 양충일</td>
                </tr>

                <tr>
                    <td>Phone</td> 
                    <td>010-8478-9331</td>
                </tr>

                <tr>
                    <td>E-mail</td> 
                    <td>kimjinpen@naver.com</td>
                </tr>

                <tr>
                    <td></td> 
                    <td></td>
                </tr>

                <tr>
                    <td></td>  
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>


<br><br>
<div style="color:#6e6e6e; width:80%;">
    * 본 서비스는 클라우드 서버가 아닌 자체 서버로 운영되고 있습니다.<br> 
    * 서버에 접근할 수 없거나 이상이 있다면 담당자에게 연락주시길 바랍니다.
</div>
    
<br><br><hr>

<?php
    require "lib/bottom.php";
?>