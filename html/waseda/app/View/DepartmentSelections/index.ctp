<h2> 学科選択調査 </h2>
<ul>
<?php echo $this->Html->tag("li", $this->Html->Link("全体の結果を確認",["controller"=>"DepartmentSelections","action"=>"result"]) ); ?>
<?php echo $this->Html->tag("li", $this->Html->Link("自分の学科選択 ".($login_id?"(id: ".$login_id.")":"(ログインが必要です)"),["controller"=>"DepartmentSelections","action"=>"user_view",$login_id]) ); ?> 
</ul>
