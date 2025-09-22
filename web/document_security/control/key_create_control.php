<?php
    // 패스워드 공백검사
    if($_POST["password_careate"] == null){
        ?>
        <script type="text/javascript">
            alert("비밀번호를 입력하세요.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }

    session_start();
    exec("mkdir /project/web/document_security/key_temp/".session_id()); // 세션 ID DIR 생성

    $password = $_POST['password_careate']; // 사용자가 입력한 password

    $file_dir = "/project/web/document_security/key_temp/".session_id(); // pem 경로
    $file_name = "key.pem"; // pem 이름
    $file = $file_dir."/".$file_name; // 경로가 포함된 pem 파일

    exec("openssl genrsa -des3 -passout pass:".$password." -out ".$file." 1024",$result,$err); // pem 파일 생성

    // 파일 업로딩
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-length: ' . filesize($file));
    header('Expires: 0');
    header("Pragma: public");

    $fp = fopen($file, 'rb');
    fpassthru($fp);
    fclose($fp);
    //

    // DIR 삭제
    exec("rm -rf ".$file_dir);
?>


