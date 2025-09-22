<?php
  require_once 'lib/common.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="/favicon.png">
    <title>[공모전] 국방 단어교정 체계</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 뭔지 확인 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
      @import url(///fonts.googleapis.com/earlyaccess/jejugothic.css);
      html,body {
        width: 100%;
        height: 100%;
        background-color: #191f2b;
        font-family: 'Jeju Gothic', sans-serif;
      }
      form input::file-selector-button {
        display: none;
      }
      .main {
        width: 100%;
        background-color: #F6F6F6;
        padding: 3% 5% 5% 5%; 
      }
      .top {
        width: 100%;
        height: 5%;    
      }
      .bottom {
        width: 100%;
        padding: 1% 1% 1% 1%;   
      }
      .content_table{
        width: 70%;
      }
    </style>
  </head>
  <body>
    <script>
      let filter = "win16|win32|win64|mac|macintel";
      if(0 > filter.indexOf(navigator.platform.toLowerCase())){
        alert("Mobile 환경에서는 지원하지 않습니다. PC의 크롬 환경에서 이용바랍니다.");
        location.href="/page_null.html";
      }
        
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js'></script>

    <div class='top'>
      <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
<!-- navbar-brand의 content 변경 -->
  <a class="navbar-brand" href="/introduce/introduce.php"><img src = "/res/main.png" width='200px' height='50px' style="margin: 0;"/></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/introduce/introduce.php">소개<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/str_correction/str_correction.php">문장검사</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/file_correction/file_correction.php">파일검사</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/filter_search/filter_search.php">필터검색</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/document_security/document_security.php">문서보안</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/request_word/request_word.php">단어추가요청</a>
      </li>
    </ul>
  </div>
</nav>
</div>

  <div class="main">