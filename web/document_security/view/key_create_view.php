<div style="color:#6e6e6e;">
    <p>
        <br>
        <lable>문서 암/복호화에 필요한 키를 생성할 수 있습니다. </lable><br>
        <lable> 해당 키는 분실될 경우 재발급이 불가능하니 신뢰할 수 있는 장소에 보관해야 합니다.</lable>
    </p>
</div>

<form action="action/key_create_action.php" method="post">
    <table class='content_table'>
        <tr>    
            <td>
                <lable>키 비밀번호</lable>
            </td>
            <td>
                <input type='password' class="form-control" name=password_careate>
            </td>
        </tr>

        <tr><td><br><br></td></tr>
        
        <tr>    
            <td></td>
            <td style='text-align : right;'>
                <input type='submit' class="btn btn-outline-primary" value = '생성'>
            </td>
        </tr>
    </table>
</form>