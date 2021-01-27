<div>
    <?php 
        echo $this->Form->create("Board",["url"=>["controller"=>"boards","action"=>"add",$toId] ] );
        echo $this->Form->hidden("Board.to_board_id",["default"=>$toId?$toId:1]);
        echo $this->Form->input("Board.title",["label"=>"タイトル"]);
        echo $this->Form->input("Board.description",["label"=>"説明"]);
        echo $this->Form->End("追加");
    ?>
</div>
