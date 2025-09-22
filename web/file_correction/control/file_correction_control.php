<?php
/*
    ****************************************************************************
    @ Name: file_correction_control.php
    @ Author: PARK JI HWAN
    @ Date: 2022. 08. 12.
    @ Update: None
    @ Comment: form으로 파일을 내려받고 필터링 수행
    *****************************************************************************
*/


    // 필터 선택 검사
    if ( !isset($_POST['military']) && !isset($_POST['korean']) && !isset($_POST['request']))
    {
        ?>
        <script type="text/javascript">
            alert("최소 1개 이상의 필터를 선택해야 합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }

    // 파일 업로드 검사 후 파일명 가공
    if( isset($_FILES["profile"]["name"]) ){
        $file_name = htmlspecialchars($_FILES["profile"]["name"]); // 파일명 escape 처리
        $file_name = str_replace(' ','_',$_FILES["profile"]["name"]); // 공백은 _ 문자로 치환
        $Filename_ex = explode('.',$_FILES["profile"]["name"]); // 파일명에서 .문자로 구분
        $Filename_ex = $Filename_ex[count($Filename_ex) - 1]; // 구분된 배열에서 마지막 배열 값(이중 확장자 제한)
    }
    
    // file size 제한 (100MB)
    $file_size = $_FILES["profile"]["size"] / 1000000;
    if ($file_size > 100)
    {
        ?>
        <script type="text/javascript">
            alert("파일은 100MB 이하만 지원합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }

    

    // 파일 확장자 검사
    if($Filename_ex != 'txt' && $Filename_ex != 'hwp')
    {
        
        ?>
        <script type="text/javascript">
            alert("현재 파일검사 기능은 hwp, txt파일만 지원합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
        
    }
    
    $target_dir = "/project/web/file_correction/temp/"; // temp 경로
    $target_file = $target_dir.basename($file_name); // 디렉터리가 포함된 파일명
    

    // 서버로 파일 업로드 후 검사
    if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
        
        ?>
        <script type="text/javascript">
            alert("파일 업로드를 실패하였습니다. 불편을 드려 죄송합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
        
    }

      
  
    // hwp / txt 문자열 추출
    if( $Filename_ex == 'hwp' ){
        $result = "";
        exec('hwp5txt '.$target_file,$result);

        $data = implode("\n",$result);
    }else if($Filename_ex == 'txt'){
        $txt_file = file($target_file);
        $data = implode("\n",$txt_file);
    }

  

    // 파일 삭제
    exec("rm -f ".$target_file,$del_result,$err);

    // 파일의 내용을 읽을 수 없거나 없다면
    if($data == null)
    {
        
        ?>
        <script type="text/javascript">
            alert("파일 읽기를 실패하였습니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
        
    }

    // db 연결
    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
        
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    // 필터링 결과를 담는 리스트(국방부, 국어원, 사용자)
    $militay_filter_result = array(); 
    $korean_filter_result = array(); 
    $request_filter_result = array(); 

    // 형태소 분석
    $out = morpheme_analysis($data);

    $json_result = array(); // ajax, json으로 보내기 위한 데이터

    if ($_POST['military'] == 'y')
    {
        foreach($out as $i){
            
            $word = $i;
            $militay_sql = 'SELECT word, prohibit FROM military_filter WHERE prohibit = "'.$word.'"' ;
            $result = mysqli_query($db_con, $militay_sql);
            
            while($row = mysqli_fetch_array($result)){
                array_push($militay_filter_result, $row);
            }
        }  
        $json_result['militay_filter_result'] = $militay_filter_result;           
    }

    // korean 필터
    if ($_POST['korean'] == 'y'){
        foreach($out as $i){
            $word = $i;
            $korean_sql = 'SELECT word, prohibit, value FROM korean_filter WHERE prohibit = "'.$word.'"' ;
            $result = mysqli_query($db_con, $korean_sql);
            while($row = mysqli_fetch_array($result)){
                array_push($korean_filter_result, $row); 
            }
        }
        $json_result['korean_filter_result'] = $korean_filter_result;
    }

    
    // 사용자 필터
    if ($_POST['request'] == 'y')
    {
        foreach($out as $i){
            $word = $i;
            $request_sql = 'SELECT word, prohibit, value FROM request_filter WHERE prohibit LIKE "'.$word.'"' ;
            $result = mysqli_query($db_con, $request_sql);
            while($row = mysqli_fetch_array($result)){
                array_push($request_filter_result, $row);
            }
        }
        $json_result['request_filter_result'] = $request_filter_result;
    }

    // json으로 전송
    $json_result['input_str'] = $data; // 추출한 문자열 json 전송
    $result = json_encode($json_result);
    echo ($result);

    // 형태소 분석 ( cmd-test : mecab -d /usr/local/lib/mecab/dic/mecab-ko-dic )
    function morpheme_analysis($str)
    {
        $tag  = array('NNG', 'NNP','NNB', 'NNBC','NR','VA','VX','VCP','VCN','MM','MAG','MAJ','IC'); // 일반명사, 고유명사, 의존명사, 수사, 형용사, 보조용언, 긍정 지정사, 부정 지정사, 관형사 , 일반부사, 접속부사, 감탄사 태그
        $result = array();
        $mecab = new \mecab\Tagger(); // mecab 객체 생성
        $result_str = $mecab->parse($str); // 형태소 분석 (type: 문자열)
        $result_array = explode("EOS",$result_str); // 분석 종료시점
        $result_array = explode("\n",$result_array[0]); 
            
        foreach($result_array as $i)
        {   
            $temp = explode("\t",$i);
            $tag_result = in_array(explode(",",$temp[1])[0],$tag);
            
            if(mb_strlen($temp[0],'utf-8') > 1 && $tag_result) // 1글자 이상이고 tag에 있는 항목만 저장
                array_push($result, $temp[0]);
        }
        return $result;
    }

?>