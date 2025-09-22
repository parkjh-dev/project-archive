<?php

    $str = $data["word"];
    $str_encode=mb_detect_encoding($str,'auto');

    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
    
    // 요청 번호
    $table_index = mysqli_query($db_con,'select value from conf where name = "user_request_index"');
    $table_index = mysqli_fetch_array($table_index);
    
    // 유저가 요청한 자료가 있으면 인덱스 번호 
    $row= mysqli_fetch_array(mysqli_query($db_con, 'SELECT * FROM user_request'));    
    if(isset($row))
    {
        $table_index = (int)$table_index['value'] + 1;
    }else{
        $table_index = 1;
    }



    if($db_con){
        echo "연결 성공";
    }else{
        ?>
        <script type="text/javascript">
            alert("시스템 오류로 요청되지 않았습니다. 불편을 드려 죄송합니다.");
            history.go(-1);
        </script>
        <?php
    }

    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    $sql = "INSERT INTO user_request(id, military_id, name, word, prohibit, value) VALUES('".$table_index."','".$data["military_id"]."','".$data["name"]."','".$data["word"]."','".$data["prohibit"]."','".$data["value"]."')";
    
    $result = mysqli_query($db_con, $sql);

    if ($result)
    {
        mysqli_query($db_con,'UPDATE conf SET value = "'.$table_index.'" WHERE name = "user_request_index"'); // index 번호 업데이트
    
        ?>
        <script type="text/javascript">
            
            location.href = '../request_word.php';
            alert("교정어:<?php echo $data["word"]; ?>\n금칙어: <?php echo $data["prohibit"]; ?>\n\n요청되었습니다. 감사합니다.");
        </script>
        <?php 
    }else{
        ?>
        <script type="text/javascript">
            alert("시스템 오류로 요청되지 않았습니다. 불편을 드려 죄송합니다.");
            history.go(-1);
        </script>
        <?php
        echo mysqli_error($db_con);
        
    }
    mysqli_close($db_con);   
?>
