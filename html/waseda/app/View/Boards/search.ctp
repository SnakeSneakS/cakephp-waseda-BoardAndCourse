<div>
    <span>
        <?php 
        if(empty($login_id)) echo $this->Html->Link("未ログイン",["controller"=>"users","action"=>"login"]);
        ?>
    </span>
    <span>
        <?php 
        if(!empty($login_id)) echo $this->Html->Link("自分がwatchしている掲示板",["controller"=>"BoardUsers","action"=>"user",$login_id]); 
        ?>
    </span>
</div>

<?php 
echo $this->Form->input("Board.title", ["label"=>"検索", "placeholder"=>"板のタイトル", "class"=>"board_incremental_search"]);
?>


<div class="boards_area"></div>


<?php echo $this->Html->script("board-incremental-search", array("inline"=>false) ); ?>