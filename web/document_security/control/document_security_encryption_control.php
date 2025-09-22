<?php
    session_start();

    // 패스워드 공백검사
    if($_POST["password_input"] == null){
        ?>
        <script type="text/javascript">
            alert("비밀번호를 입력하세요.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }

    // 키 파일 확장자 검사
    $Filename_ex = explode('.',$_FILES["keyfile"]["name"]); // 파일명에서 .문자로 구분
    $Filename_ex = $Filename_ex[count($Filename_ex) - 1]; // 구분된 배열에서 마지막 배열 값(이중 확장자 제한)
    if($Filename_ex != 'pem'){
        ?>
        <script type="text/javascript">
            alert("키 파일이 아닙니다. pem 확장자로 된 파일을 업로드해주세요.");
            history.go(-1);
        </script>
        <?php
        exit(-1);   
    } 
    
    // 사용자 입력 패스워드
    $password = $_POST["password_input"];

    // 암/복호화 파일 업로드
    $targetfile_name = $_FILES["targetfile"]["name"]; // 타겟 파일명
    $keyfile_name = $_FILES["keyfile"]["name"]; // 키 파일명

    // 복호화 파일 확장자 검사
    $targetfile_ex = explode('.',$_FILES["targetfile"]["name"]);
    $targetfile_ex = $targetfile_ex[count($targetfile_ex) - 1];

    if ($_POST['type'] == 'decryption' && $targetfile_ex != 'enc'){
        ?>
        <script type="text/javascript">
            alert("복호화 파일이 아닙니다. enc 확장자로 된 파일을 업로드해주세요.");
            history.go(-1);
        </script>
        <?php
        exit(-1);  
    }
    
    
    $targetfile_name = str_replace(" ", "_", $targetfile_name); // 파일이름 공백 제거
    $keyfile_name = str_replace(" ", "_", $keyfile_name); // 파일이름 공백 제거

    // 암/복호화 경로 지정
    $encryption_dir = "/project/web/document_security/encryption_temp/";
    $decryption_dir = "/project/web/document_security/decryption_temp/";    
    
    switch($_POST['type']){
        case 'encryption':
            exec("mkdir ".$encryption_dir.session_id());
            $targetdir = $encryption_dir.session_id().'/';
            $targetfile = $targetdir.basename($targetfile_name);
            $keyfile = $targetdir.basename($keyfile_name);
            break;
        case 'decryption':
            exec("mkdir ".$decryption_dir.session_id());
            $targetdir = $decryption_dir.session_id().'/';
            $targetfile = $targetdir.basename($targetfile_name);
            $keyfile = $targetdir.basename($keyfile_name);
            break;
    }
  
    // 파일 업로드
    if (!move_uploaded_file($_FILES["targetfile"]["tmp_name"], $targetfile) || !move_uploaded_file($_FILES["keyfile"]["tmp_name"], $keyfile)){
        ?>
        <script type="text/javascript">
            alert("파일 업로드에 실패하였습니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }
    //

    if ($_POST['type'] == 'encryption'){

        exec("openssl rand -base64 32 >".$targetdir."key.bin"); // 공개키 생성 (랜덤값)
        
        // 암호화 파일 및 공개키를 저장하는 디렉터리 생성
        $result_dir = $targetdir.explode(".",$targetfile_name)[0]; 
        exec("mkdir ".$result_dir); 

        $out_file = $result_dir."/".$targetfile_name; // 출력 파일
        exec("openssl enc -aes-256-cbc -salt -in ".$targetfile." -out ".$out_file." -pass file:".$targetdir."key.bin"); // 대상파일 암호화
        exec("openssl rsautl -encrypt -passin pass:".$password." -inkey ".$keyfile." -in ".$targetdir."key.bin -out ".$result_dir."/key.bin.enc"); //공개키 파일 암호화
        exec("tar -cf ".$result_dir.".enc -C".$result_dir." ."); // 암호화파일 및 공개키 압축
        
        // 암호화 파일 내려받기
        file_download(explode(".",$targetfile_name)[0].".enc", $targetdir.explode(".",$targetfile_name)[0].".enc");
        
        // 디렉터리 삭제
        exec("rm -rf ".$targetdir);

    }else if($_POST['type'] == 'decryption'){

        $encryptionfile_name = ''; // 복호화 대상파일 이름
        exec("tar -xvf ".$targetfile." -C ".$targetdir,$result); // 압축 풀기
        
        // 압축목록에서 복호화 대상 선정
        foreach ($result as $i){
            $i = explode("./",$i);
            if ($i[1] != 'key.bin.enc') $encryptionfile_name = $i[1];
        }
        $out_file = $targetdir.$encryptionfile_name; // 출력 파일
        
        exec("mv ".$out_file." ".$targetdir."encryption_".$encryptionfile_name); // 내려받은 파일(암호화)명에 encrypyion_ 추가
       
        exec("openssl rsautl -decrypt -passin pass:".$password." -inkey ".$keyfile." -in ".$targetdir."key.bin.enc -out ".$targetdir."key.bin"); // 공개키 복호화
        exec("openssl enc -d -aes-256-cbc -salt -in ".$targetdir."encryption_".$encryptionfile_name." -out ".$out_file." -pass file:".$targetdir."key.bin"); // 암호화 파일 복호화

        // 복호화 파일 내려받기
        file_download($encryptionfile_name, $out_file);
        
        // 디렉터리 삭제
        //exec("rm -rf ".$targetdir);

    }

    // 웹 브라우저에서 파일을 다운로드하는 함수    
    function file_download($file_name, $file){

        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-length: ' . filesize($file));
        header('Expires: 0');
        header("Pragma: public");

        $fp = fopen($file, 'rb');
        fpassthru($fp);
        fclose($fp);
    }
// To - Do
// (1)검사
// 파일명 한글 오류
// 키파일 및 비밀번호 불일치 결과 출력
?>