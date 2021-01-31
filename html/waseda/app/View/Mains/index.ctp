
<h2>管理者</h2>
<p> <?php echo $this->Html->Link("管理者用",["controller"=>"Admins","action"=>"index"]); ?> </p>

<h2>マイページ</h2>
<p> <?php echo $this->Html->Link("マイページ",["controller"=>"users","action"=>"index"]); ?> </p>
<p> <?php echo $this->Html->Link("学科選択調査",["controller"=>"DepartmentSelections","action"=>"index"]); ?> </p>

<h2>掲示板</h2>
<p> <?php echo $this->Html->Link("掲示板",["controller"=>"Boards","action"=>"index"]); ?> </p>
