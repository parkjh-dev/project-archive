<?php

    $data = array(
        "military_id"=>htmlspecialchars($_POST['military_id']),
        "name"=>htmlspecialchars($_POST['name']),
        "word"=>htmlspecialchars($_POST['word']),
        "prohibit"=>htmlspecialchars($_POST['prohibit']),
        "value"=>htmlspecialchars($_POST['value'])
    );
    
    $error = array();
    
    foreach ($data as $k => $v){
        validation($v,$k);
    }

    if($error){
        ?>
            <script type="text/javascript">
                alert("<?php foreach ($error as $b) echo($b.'\n') ?>");
                history.go(-1);
            </script>
        <?php
    }else{
        require_once "/project/web/request_word/control/requst_word_control.php";
    }

    // 정규식 검사
    function validation($input, $type)
    {
        global $error;

        switch($type){
            case 'military_id':
                if (!preg_match('/^[0-9|-]{4,12}$/',$input)){
                    array_push($error,"군번이 올바르지 않습니다.");
                }
                break;
            case 'name':
                if (!preg_match('/^[a-z|A-Z|가-힣]{1,20}$/',$input)){
                    array_push($error,"이름의 글자수를 초과하였거나 사용할 수 없는 기호가 포함되어 있습니다.");
                }
                break;
            case 'word':
            case 'prohibit':
                if (!preg_match('/^.{1,50}$/',$input)){
                    array_push($error,"교정어 또는 금칙어의 글자수를 초과하였습니다.");
                }
                break;
            case 'value':
                if (!preg_match('/^.{1,200}$/',$input)){
                    array_push($error,"내용의 글자수를 초과하였습니다.");
                }
                break;       
        }
    }
?>

