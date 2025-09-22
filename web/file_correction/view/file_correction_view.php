<?php 
    require_once 'lib/top.php';
  
    $filter_version = get_filter_info();
?>

<h3>파일 검사</h3><hr/>

<div style="color:#6e6e6e;">
    <p>
        <lable>사용자가 작성한 문서를 업로드하여 검사할 수 있습니다.</lable><br>
        <lable>확장자는 hwp, txt 파일만 가능합니다.</lable>
        <lable>3가지 필터(국방부, 국어원, 관리자) 중 사용자가 원하는 필터를 적용하여 검사를 수행할 수 있습니다.</lable>
    </p>
</div>

           
<form name='file_correction' id='file_correction' action='action/file_correction_action.php' enctype='multipart/form-data' method='post'>
    <table class = 'content_table'>
        <tr>        
            <td>
                <label>필터링 파일 업로드</label>
            </td>
            <td></td>
        </tr>

        <tr>        
            <td>
                <input type="file" class="btn btn-outline-primary" name="profile"  required/>
            </td>
            <td></td>
        </tr>

        <tr><td><br><br></td></tr>
        <tr>        
            <td colspan="2">
            <textarea class="form-control" id='input_str' readonly placeholder="추출 문자열"  cols="130" rows="8"></textarea>			
            <textarea class="form-control" id='input_data' readonly placeholder="검사 결과"  cols="130" rows="8"></textarea>			

            </td>
            <td></td>
        </tr>
        <tr><td><br><br></td></tr>
        
        <tr>        
            <td>
                <lable>적용 필터</lable>
            </td>
            <td></td>
        </tr>

        <tr>  
            <td colspan="2">
                <section class="border py-3" style = "width:100%; padding:10px 10px 10px 10px; background-color:white;">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name='military' value='y' id="f-military" class="custom-control-input">
                        <label class="custom-control-label" for="f-military">국방부 필터 (국방데이터 표준단어 OpenData 필터.) [<?php echo $filter_version['military_filter_version']['count']; ?> 단어 보유]</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name='korean' value='y' id="f-korean" class="custom-control-input">
                        <label class="custom-control-label" for="f-korean">국어원 필터 (국립국어원 사전의 방언을 포함한 필터.) [<?php echo $filter_version['korean_filter_version']['count']; ?>단어 보유]</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name='request' value='y' id="f-request" class="custom-control-input">
                        <label class="custom-control-label" for="f-request">관리자 필터 (사용자가 요청하고 관리자 등록한 필터.) [<?php echo $filter_version['request_filter_version']['count']; ?>단어 보유]</label>
                    </div>
                </section>
            </td>
            
        </tr>

        <tr><td><br><br></td></tr>

        <tr>
            <td></td>
            <td style='text-align : right;'>
                <button class="btn btn-outline-primary">검사시작</button>
            </td>
        </tr>
    </table>
</form>


<script>
    $(function() {
        $('#file_correction').ajaxForm({
            dataType: 'json',
            
            complete: function(data) {
                var html = "";
                var str = data.responseJSON.request_filter_result.length;
                // 국방부 필터
                if(data.responseJSON.militay_filter_result != null){
                    html+="[국방부 필터]\n";
                    for(var i = 0; i < data.responseJSON.militay_filter_result.length; i++){
                        html+="금칙어: "+data.responseJSON.militay_filter_result[i]['prohibit']+"\t교정어: "+data.responseJSON.militay_filter_result[i]['word']+"\t\t내용: "+data.responseJSON.militay_filter_result[i]['value']+"\n";
                    }
                    if(data.responseJSON.militay_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
                    html+="\n";
                }
                // 국어원 필터
                if(data.responseJSON.korean_filter_result != null){
                    html+="[국어원 필터]\n";
                    for(var i = 0; i < data.responseJSON.korean_filter_result.length; i++){
                        html+="금칙어: "+data.responseJSON.korean_filter_result[i]['prohibit']+"\t교정어: "+data.responseJSON.korean_filter_result[i]['word']+"\t\t내용: "+data.responseJSON.korean_filter_result[i]['value']+"\n";
                    }
                    if(data.responseJSON.korean_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
                    html+="\n";
                }
                // 관리자 필터
                if(data.responseJSON.request_filter_result != null){
                    html+="[관리자 필터]\n";
                    for(var i = 0; i < data.responseJSON.request_filter_result.length; i++){
                        html+="금칙어: "+data.responseJSON.request_filter_result[i]['prohibit']+"\t교정어: "+data.responseJSON.request_filter_result[i]['word']+"\t\t내용: "+data.responseJSON.request_filter_result[i]['value']+"\n";
                    }
                    if(data.responseJSON.request_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
                    html+="\n";
                }
                $("#input_str").html(data.responseJSON.input_str);
                $("#input_data").html(html);     
            }
        });
    });	
</script>
                
<?php 
    require_once 'lib/bottom.php';
?>