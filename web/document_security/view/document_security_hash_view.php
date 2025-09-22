<div style="color:#6e6e6e;">
    <p>
        <br>
        <lable>사용자가 업로드한 파일의 해시값을 확인할 수 있습니다. </lable><br>
        <lable>선택가능한 해시는 MD5, SHA256 함수가 있습니다.</lable>
        <lable>파일의 해시값을 확인하여 해당 파일의 무결성을 검증할 수 있습니다.</lable>
    </p>
</div>

<form name='hash' id='hash' action="action/document_security_hash_action.php" method="post" enctype="multipart/form-data">
        <table class = 'content_table'>
                <tr>
                        <td>
                                <lable>대상파일</lable>
                        </td>
                        <td>
                                <lable>해시 알고리즘</lable>
                        </td>
                </tr>

                <tr>
                        <td>
                                <input type="file" class="btn btn-outline-primary" name="profile"  required/>
                        </td>
                        <td>
                                <div class="form-inline">
                                        <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name='MD5' value='y' id="enc-MD5" class="custom-control-input">
                                                        <label class="custom-control-label" for="enc-MD5">MD5&nbsp; &nbsp; &nbsp;</label>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name='SHA256' value='y' id="enc-SHA256" class="custom-control-input">
                                                        <label class="custom-control-label" for="enc-SHA256">SHA256</label>
                                                </div>
                                        </div>
                                </div>
                        </td>
                </tr>

                <tr><td><br><br></td></tr>
                
                <tr>
                <td colspan="2">
                        <textarea class="form-control" id='input_result' readonly placeholder="해시 결과"  cols="130" rows="2"></textarea>			
                </td>
                </tr>
                <tr><td><br><br></td></tr>
                <tr>
                        <td></td>
                        <td style='text-align : right;'>
                                <button class="btn btn-outline-primary">확인</button>
                        </td>
                </tr>            
        </table>
</form>

<script>
    $(function() {
        $('#hash').ajaxForm({
            dataType: 'json',
            
            complete: function(data) {
                var result = '';
                if(data.responseJSON.MD5 != null){
                        result+="MD5: "+data.responseJSON.MD5+'\n';
                }
                if(data.responseJSON.SHA256 != null){
                        result+="SHA256: "+data.responseJSON.SHA256+'\n';
                }

                $("#input_result").html(result);    
            }
        });
    });	
</script>