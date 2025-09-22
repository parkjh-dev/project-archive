<?php
    if ( !isset($_POST['MD5']) && !isset($_POST['SHA256']))
    {
        ?>
        <script type="text/javascript">
            alert("최소 1개 이상의 해시 알고리즘을 선택해야 합니다.");
            history.go(-1);
        </script>
        <?php
        exit(0);
    }
    $json_result = array(); // ajax, json으로 보내기 위한 데이터
    $file_name = $_FILES["profile"]["name"]; 
    $file_name = str_replace(" ", "_", $file_name); // 파일이름 공백 제거

    $target_dir = "/project/web/document_security/hash_temp/";   
    $target_file = $target_dir.basename($file_name);

    // 파일 업로드
    if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)){
        ?>
        <script type="text/javascript">
            alert("파일 업로드에 실패하였습니다.");
            history.go(-1);
        </script>
        <?php
        exit(0);
    }
    
    // 해시 결과 
    $hash_result = array();

    // MD5 해시 추출
    if(isset($_POST['MD5'])){
        exec("openssl dgst -MD5 ".$target_file,$MD5_result);
        $hash_result['MD5'] =  explode('=' , $MD5_result[0])[1];
    }

    // SHA256 해시 추출
    if(isset($_POST['SHA256'])){
        exec("openssl dgst -SHA256 ".$target_file,$SHA256_result);
        $hash_result['SHA256'] =  explode('=' , $SHA256_result[0])[1];
    }

    // 파일 삭제
    exec('rm -f '.$target_file);

    $json_result['MD5'] = $hash_result['MD5'];
    $json_result['SHA256'] = $hash_result['SHA256'];
    $result = json_encode($json_result);
    echo ($result);
    //print($hash_result['MD5']);
    //print($hash_result['SHA256']);
?>