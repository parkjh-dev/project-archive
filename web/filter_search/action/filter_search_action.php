<?php
    // 필터 선택 및 검색어 공백 검사
    if ( (!isset($_POST['military']) && !isset($_POST['korean']) && !isset($_POST['request']) ) || $_POST['str'] == null)
    {
        ?>
        <script type="text/javascript">
            alert("최소 1개 이상의 필터 선택과 검색어를 입력해야 합니다.");
            history.go(-1);
        </script>
        <?php
        exit(-1);
    }
    require_once "/project/web/filter_search/control/filter_search_control.php";
?>