<?php 
    require_once 'lib/top.php';
?>
<h3>단어 추가요청</h3><hr/>
<div style="color:#6e6e6e;">
    <p>
        <lable>사용자가 추가하고자하는 필터를 관리자에게 요청할 수 있습니다.</lable><br>
        <lable>관리자는 사용자가 요청한 필터를 검토후 등록하여 모든 사용자가 사용할 수 있습니다.</lable>
    </p>
</div>
 

<form action="action/requst_word_action.php" accept-charset="utf-8" name="a" method="POST">
    <table class='content_table'>
        <tr>
            <td>
                <label>군번</label>
            </td>
            <td>
                <label>이름</label>
            </td>
        </tr>

        <tr>
            <td>
                <input type="text" class="form-control" name="military_id" placeholder="ex) 19-12283" style="width:70%;"/>
            </td>
            <td>
                <input type="text" class="form-control" name="name" placeholder="ex) 홍길동" style="width:70%;"/>
            </td>
        </tr>

        <tr><td><br></td></tr>
        
        <tr>
            <td>
                <label>교정어</label>
            </td>
            <td>
                <label>금칙어</label>
            </td>
        </tr>

        <tr>
            <td>
                <input type="text" class="form-control" name="word" placeholder="ex) 방탄모" style="width:70%;"/>
            </td>
            <td>
                <input type="text" class="form-control" name="prohibit" placeholder="ex) 하이바" style="width:70%;"/>
            </td>
        </tr>

        <tr><td><br></td></tr>

        <tr>
            <td colspan="2">
                <label>내용</label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <textarea class="form-control" placeholder="요청 사유를 기입해주세요."  name="value" cols="130" rows="5"></textarea>
            </td>
            <td>
            </td>
        </tr>

        <tr><td><br></td></tr>

        <tr>
            <td>
            </td>
            <td style='text-align : right;'>
                <input type="submit" class="btn btn-outline-primary" value="추가요청"/>
            </td>
        </tr>


    </table>
</form>


<?php 
    require_once 'lib/bottom.php';
?>