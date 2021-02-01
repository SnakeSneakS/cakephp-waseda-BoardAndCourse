<?php 
echo $this->Form->input("Board.title", ["label"=>"検索", "placeholder"=>"板のタイトル", "class"=>"board_incremental_search"]);
?>


<div class="boards_area"></div>


<?php echo $this->Html->script("board-incremental-search", array("inline"=>false) ); ?>