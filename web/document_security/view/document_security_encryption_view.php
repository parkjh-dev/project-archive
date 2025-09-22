<div style="color:#6e6e6e;">
    <p>
        <br>
        <lable>사용자가 업로드한 문서를 암/복호화 할 수 있습니다. </lable><br>
        <lable>암/복호화 대상파일과 키파일, 비밀번호를 입력하고 암호화 또는 복호화를 수행합니다.</lable>
        <lable>키 파일은 '키 생성'탭에서 생성이 가능하며, 확장자는 pem만 업로드 가능합니다.</lable>
        <lable>복호화 파일은 현 체계에서 암호화한 enc 확장자만 업로드 가능합니다.</lable>
    </p>
</div>

<form action="action/document_security_encryption_action.php" method="post" enctype="multipart/form-data">      
  <table class = 'content_table'>
    <tr>
      <td>
        <label>대상파일</label>
      </td>
      <td>
        <label>키파일</label>
      </td>
    </tr>
    
    <tr>
      <td>
        <input type="file" class="btn btn-outline-primary" id='targetfile' name="targetfile"  required/>
      </td>
      <td>
        <input type="file" class="btn btn-outline-primary" name="keyfile"  required/>
      </td>
    </tr>

    <tr><td><br></td></tr>
    
    <tr>
      <td>
        <label>키 비밀번호</label>
      </td>
      <td></td>
    </tr>

    <tr>
      <td>
        <input type='password' class="form-control" name='password_input' style="width:70%;">
      </td>
      <td></td>
    </tr>

    <tr><td><br></td></tr>
    
    <tr>
      <td>
        <label>타입</label>
      </td>
      <td>
        <label>암호 알고리즘</label>
      </td>
    </tr>

    <tr>
      <td>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-primary">
						  <input type="radio" name="type" id="jb-radio-1" value="encryption"> 암호화
					</label>
					<label class="btn btn-primary">
						<input type="radio" name="type" id="jb-radio-2" value="decryption"> 복호화
					</label>
        </div>
      </td>
      <td>
          <div class="custom-control custom-checkbox">
						<input type="checkbox" name='AES' value='y' id="enc-AES" class="custom-control-input" checked disabled>
						<label class="custom-control-label" for="enc-AES">AES</label>
					</div>
      </td>
    </tr>

    <tr><td><br><br></td></tr>
    
    <tr>
      <td></td>
      <td style='text-align : right;'>
        <input type="submit" class="btn btn-outline-primary" value="확인">
      </td>
    </tr>
        
  </table>   
</form>                   