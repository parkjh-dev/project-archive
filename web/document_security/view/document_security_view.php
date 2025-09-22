<?php 
    require_once "lib/top.php";
?>
<h3>문서보안</h3><hr/>

<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#hash">파일 해시</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#encryption">문서 암/복호화</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#key_create">키 생성</a>
          </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="hash">
                <?php require_once 'document_security/view/document_security_hash_view.php';?>
            </div>
            <div class="tab-pane fade" id="encryption">
                <?php require_once 'document_security/view/document_security_encryption_view.php';?>
            </div>
            <div class="tab-pane fade" id="key_create">
                <?php require_once 'document_security/view/key_create_view.php';?>
            </div>
        </div>
    </div>
</div>
  
<?php 
    require_once "lib/bottom.php";
?>