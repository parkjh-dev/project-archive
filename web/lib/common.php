<?php

    // 필터의 버전을 가져오는 함수 
    function get_filter_info()
    {
        $filter_info = array();

        $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');

        $sql = mysqli_query($db_con,'select * from conf where name = "military_filter_version" OR name = "korean_filter_version" OR name = "request_filter_version"');        

        while($result = mysqli_fetch_array($sql))
        {
            $split = explode(',',$result['value']);

            $filter_info[$result['name']] = array('version'=>$split[0],'count' => $split[1]);
        }
        
        mysqli_close($db_con);
        return $filter_info ;
    }

?>