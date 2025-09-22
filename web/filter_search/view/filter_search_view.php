<?php 
    require_once 'lib/top.php';
?>
<h3>필터검색</h3><hr/>

<div style="color:#6e6e6e;">
    <p>
        <lable>필터의 내용을 검색할 수 있습니다.</lable><br>
        <lable>검색하고자하는 내용(금칙어, 교정어, 내용)을 선택하고 3가지 필터(국방부, 국어원, 사용자)중 자신이 검색하고자하는 대상을 선택 후 검색합니다.</lable>
    </p>
</div>

<form name = 'filter_search' id="filter_search">
    <table>
        <tr>
            <td>
                <div class="form-inline">
                    <div class="form-group">
                        <select name='type' class="form-control" > 
                            <option value="prohibit" selected="selected">금칙어</option>
                            <option value="word">교정어</option>
                            <option value="value">내용</option>
                        </select>
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <input type='text' class="form-control" name='str'>
                        &nbsp;&nbsp;
                        <input class="btn btn-outline-primary" type="button" onclick = data_submit() value = "검색">
                    </div>  
                </div>
            </td>

            <td>
                <div class="form-inline">
                &nbsp; &nbsp; &nbsp;
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
						    <input type="checkbox" name='military' value='y' id="se-military" class="custom-control-input">
						    <label class="custom-control-label" for="se-military">국방부</label>
					    </div>
                    </div>
                    &nbsp; &nbsp; &nbsp;
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
						    <input type="checkbox" name='korean' value='y' id="se-korean" class="custom-control-input">
						    <label class="custom-control-label" for="se-korean">국어원</label>
					    </div>
                    </div>
                    &nbsp; &nbsp; &nbsp;
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
						    <input type="checkbox" name='request' value='y' id="se-request" class="custom-control-input">
						    <label class="custom-control-label" for="se-request">사용자</label>
					    </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <br>
    <div id="data_count" style='width:70%; text-align : right; color:#6e6e6e;'></div>
    <br>
    <table class="table table-striped" style="width:70%;">
        <thead>
            <tr>
                <th><label>순번</label></th>
                <th><label>필터</label></th>
                <th><label>금칙어</label></th>
                <th><label>교정어</label></th>
                <th><label>내용</label></th>    
            </tr>
        </thead>
        <tbody id="input_data"></tbody>
    </table>
</form>

<script>
    function data_submit(){
        var params = jQuery("#filter_search").serialize()
        $.ajax({
            url: "action/filter_search_action.php",
            type: "POST",
            data: params,
            dataType:'json'
                
        }).done(function(data) {
            var html = "";
            for(var i=0; i < data.data_count; i++){
                html+="<tr>";
                html+="<td>"+data.search_result[i]['number']+"</td>";
                html+="<td>"+data.search_result[i]['type']+"</td>";
                html+="<td>"+data.search_result[i]['prohibit']+"</td>";
                html+="<td>"+data.search_result[i]['word']+"</td>";
                html+="<td>"+data.search_result[i]['value']+"</td>";
                html+="</tr>";
            }
            $('#data_count').text(data.data_count+"건의 데이터를 찾았습니다.");
            $("#input_data").html(html);
        });
}
</script>


<?php
    require "lib/bottom.php";
?>