<script>
        let filter = "win16|win32|win64|mac|macintel";
        if(0 > filter.indexOf(navigator.platform.toLowerCase())){
            alert("Mobile 환경에서는 지원하지 않습니다. PC의 크롬 환경에서 이용바랍니다.");
            location.href="/page_null.html";
        }else{
            location.href="/introduce/introduce.php";
        }
</script>