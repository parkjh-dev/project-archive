<?php

    $search_type = $_POST['type']; // 검색 타입 (prohibit / word / value)
    $turn_number = 1; // 검색 결과 index
    $search_str = $_POST['str'];// 검색어
    $search_result = array(); // 검색 결과를 저장하는 리스트

    // db 연결
    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
        
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");


    // 국방부 필터 select
    if($_POST['military'] == 'y'){
        $military_sql = 'SELECT * FROM military_filter WHERE '.$search_type.' LIKE "%'.$search_str.'%"';
        $result = mysqli_query($db_con, $military_sql);

        while($row = mysqli_fetch_array($result)){
            $row['type'] = "국방부";
            $row['number'] = $turn_number;
            $turn_number++;
            array_push($search_result, $row);
        }
    }

    // 국어원 필터 select
    if($_POST['korean'] == 'y'){
        $korean_sql = 'SELECT * FROM korean_filter WHERE '.$search_type.' LIKE "%'.$search_str.'%"';
        $result = mysqli_query($db_con, $korean_sql);
   
        while($row = mysqli_fetch_array($result)){
            $row['type'] = "국어원";
            $row['number'] = $turn_number;
            $turn_number++;
            array_push($search_result, $row);
        }
    }

    // 사용자 필터 select
    if($_POST['request'] == 'y'){
        $request_sql = 'SELECT * FROM request_filter WHERE '.$search_type.' LIKE "%'.$search_str.'%"';
        $result = mysqli_query($db_con, $request_sql);
   
        while($row = mysqli_fetch_array($result)){
            $row['type'] = "사용자";
            $row['number'] = $turn_number;
            $turn_number++;
            array_push($search_result, $row);
        }
    }

    $data_count = count($search_result); // 검색한 총 데이터 개수
    
    $result = json_encode(array('search_result'=>$search_result, 'data_count' => $data_count));
    echo ($result);
   
?>