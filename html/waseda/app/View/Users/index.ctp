<h2>ユーザ</h2>
<ul>
<?php 
    if( !empty($login_id) ){
        echo $this->Html->tag("li", $this->Html->Link("マイページ (id:".$login_id.")",["controller"=>"users","action"=>"view",$login_id]) );
        echo $this->Html->tag("li", $this->Html->Link("ログアウト",["controller"=>"users","action"=>"logout"]) );
    }else{
        echo $this->Html->tag("li", $this->Html->Link("ログイン",["controller"=>"users","action"=>"login"]) );
        echo $this->Html->tag("li", $this->Html->Link("新規登録",["controller"=>"users","action"=>"add"]) );
    }
?>

</ul>
