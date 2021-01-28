<h2>ユーザ</h2>
<ul>
<li> <?php echo $this->Html->Link("マイページ (id:1)",["controller"=>"users","action"=>"view",1]); ?> </li>
<li> <?php echo $this->Html->Link("ログイン",["controller"=>"users","action"=>"login"]); ?> </li>
<li> <?php echo $this->Html->Link("ログアウト",["controller"=>"users","action"=>"logout"]); ?> </li>
<li> <?php echo $this->Html->Link("新規追加",["controller"=>"users","action"=>"add"]); ?> </li>
</ul>
