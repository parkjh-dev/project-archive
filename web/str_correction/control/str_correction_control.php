<?php
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

    if ( $_POST['input_str'] == null )
    {
        ?>
        <script type="text/javascript">
            alert("검사대상을 입력해야 합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }

    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
        
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    $militay_filter_result = array();
    $korean_filter_result = array();
    $request_filter_result = array();
    
    $input_str = $_POST['input_str'];

    $out = morpheme_analysis($input_str); // 형태소 분리
    
    $json_result = array(); // ajax, json으로 보내기 위한 데이터

    // military 필터
    if ($_POST['military'] == 'y')
    {
        foreach($out as $i){
            $word = $i;
            $militay_sql = 'SELECT word, prohibit FROM military_filter WHERE prohibit LIKE "'.$word.'"' ;
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


