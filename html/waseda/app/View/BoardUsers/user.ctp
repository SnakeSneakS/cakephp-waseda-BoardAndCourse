<?php //debug($boards); debug($user); ?>

<div>
    <h2>
        <?php echo $this->Html->Link($user["User"]["username"], ["controller"=>"users", "actions"=>"view", $user["User"]["id"] ]  ) ?>
        がwatchしている掲示板： 
    </h2>
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
