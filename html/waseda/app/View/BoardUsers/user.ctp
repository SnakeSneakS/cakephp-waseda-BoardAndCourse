<?php //debug($boards); debug($user); ?>

<div>
    <span>
        <?php echo $this->Html->Link($user["User"]["username"], ["controller"=>"users", "actions"=>"view", $user["User"]["id"] ]  ) ?>
        がwatchしている掲示板： 
    </span>
</div>


<div class="boards_area">
    <?php foreach($boards as $board): ?>
    <div class="board">
        <div>
            <span class="board_link"> <?php echo $this->html->link($board["Board"]["title"],["controller"=>"boards","action"=>"view",$board["Board"]["id"]]);?> </span>
            <span class="small"> <?php echo $board["Board"]["modified"]; ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>


<div>
<span>Sort by: </span>
<?php 
if(isset($boards)){
    echo "<span>".$this->Paginator->sort('Board.title', 'タイトル', ["direction"=>"asc"])." </span>"; 
    echo "<span>".$this->Paginator->sort('Board.modified', '更新日時', ["direction"=>"asc"])." </span>"; 
}
?>
</div>

<div class="paginate_numbers">
<?php
echo $this->Paginator->numbers([
    "first"=>1,
    "last"=>1,
    "modulus"=>4,
    "separator"=>"　",
    "ellipsis"=>"　...　",
    "class"=>"",
    "currentClass"=>"",
]);
?>
</div>