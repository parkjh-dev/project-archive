
<?php 
    require_once 'lib/top.php';
	$filter_version = get_filter_info();
?>
<h3 style>문장 검사</h3><hr/>
<div style="color:#6e6e6e;">
    <p>
        <lable>500자 이내의 문장을 입력하여 검사할 수 있습니다.</lable><br>
        <lable>3가지 필터(국방부, 국어원, 관리자) 중 사용자가 원하는 필터를 적용하여 검사를 수행할 수 있습니다.</lable>
    </p>
</div>

    <form name='str_correction' id='str_correction'>
		<table class = 'content_table'>
			<tr>
				<td colspan="2">
					<textarea class="form-control" placeholder="문장을 입력하세요. <500자 이내>"  cols="130" rows="8" onkeyup='counter(this,500)' id='input_str' name='input_str'></textarea>
				</td>
			</tr>

			<tr>
				<td></td>
				<td style='text-align : right;'>
					<span id = 'reCount'>0 / 500자</span>
				</td>
			</tr>
			<tr><td><br><br></td></tr>
			<tr>
				<td colspan="2">
					<textarea class="form-control" id='input_data' readonly placeholder="검사 결과"  cols="130" rows="8"></textarea>
					<hr>
				</td>
			</tr>
			<tr><td><br></td></tr>
			<tr>
				<td><label>적용필터</label></td>
				<td></td>	
			</tr>
			
			<tr>
				<td colspan="2">
					<section class="border py-3" style = "width:100%;height:30%; padding:10px 10px 10px 10px; background-color:white;">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name='military' value='y' id="s-military" class="custom-control-input">
							<label class="custom-control-label" for="s-military">국방부 필터 (국방데이터 표준단어 OpenData 필터.) [<?php echo $filter_version['military_filter_version']['count']; ?> 단어 보유]</label>
						</div>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" name='korean' value='y' id="s-korean" class="custom-control-input">
							<label class="custom-control-label" for="s-korean">국어원 필터 (국립국어원 사전의 방언을 포함한 필터.) [<?php echo $filter_version['korean_filter_version']['count']; ?>단어 보유]</label>
						</div>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" name='request' value='y' id="s-request" class="custom-control-input">
							<label class="custom-control-label" for="s-request">관리자 필터 (사용자가 요청하고 관리자 등록한 필터.) [<?php echo $filter_version['request_filter_version']['count']; ?>단어 보유]</label>
						</div>
					</section>
				</td>
			</tr>
			<tr><td><br><br></td></tr>
			<tr>
      			<td></td>
      			<td style='text-align : right;'>
					<input type="button" onclick=data_submit() class="btn btn-outline-primary" value="검사시작">
      			</td>
    		</tr>  
		</table>  
	</form>

<script>
	function data_submit(){
		var params = jQuery("#str_correction").serialize()
        $.ajax({
            url: "action/str_correction_action.php",
            type: "POST",
            data: params,
            dataType:'json'
                
        }).done(function(data) {
            var html = "";
			var str = "";
			// 국방부 필터
            if(data.militay_filter_result != null){
				html+="[국방부 필터]\n";
				for(var i = 0; i < data.militay_filter_result.length; i++){
					html+="금칙어: "+data.militay_filter_result[i]['prohibit']+"\t교정어: "+data.militay_filter_result[i]['word']+"\t\t내용: "+data.militay_filter_result[i]['value']+"\n";
				}
				if(data.militay_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
				html+="\n";
			}
			// 국어원 필터
			if(data.korean_filter_result != null){
				html+="[국어원 필터]\n";
				for(var i = 0; i < data.korean_filter_result.length; i++){
					html+="금칙어: "+data.korean_filter_result[i]['prohibit']+"\t교정어: "+data.korean_filter_result[i]['word']+"\t\t내용: "+data.korean_filter_result[i]['value']+"\n";
				}
				if(data.korean_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
				html+="\n";
			}
			// 관리자 필터
			if(data.request_filter_result != null){
				html+="[관리자 필터]\n";
				for(var i = 0; i < data.request_filter_result.length; i++){
					html+="금칙어: "+data.request_filter_result[i]['prohibit']+"\t교정어: "+data.request_filter_result[i]['word']+"\t\t내용: "+data.request_filter_result[i]['value']+"\n";
				}
				if(data.request_filter_result.length == 0) html+="검색 결과가 없습니다.\n";
				html+="\n";
			}
			$("#input_data").html(html);
        });
	}

	function counter(text,length){
		var limit = length;
		var str = text.value.length;
		if(str > limit){
			document.getElementById('reCount').innerHTML = "500자 이상으로 입력했습니다.";
			text.value=text.value.substring(0,limit);
			text.focus();
		}else{
		document.getElementById('reCount').innerHTML = text.value.length + " / " + limit +"자";
		}
	}
</script>



<?php
    require "lib/bottom.php";
?>
  
