
<h2>Admin</h2>
<p> <?php echo $this->Html->Link("Admins",["controller"=>"Admins","action"=>"index"]); ?> </p>

<h2>Mypage</h2>
<p> <?php echo $this->Html->Link("MyPage view 1",["controller"=>"Mypages","action"=>"view",1]); ?> </p>
<p> <?php echo $this->Html->Link("Mypage add",["controller"=>"Mypages","action"=>"add"]); ?> </p>