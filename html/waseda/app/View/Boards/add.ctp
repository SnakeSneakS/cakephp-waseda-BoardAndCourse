<div>
    <?php 
        echo $this->Form->create("Board",["url"=>["controller"=>"boards","action"=>"add",$to_board_id] ] );
        echo $this->Form->hidden("Board.user_id",["default"=>!empty($login_id)?$login_id:null]);
        echo $this->Form->hidden("Board.to_board_id",["default"=>!empty($to_board_id)?$to_board_id:null]);
        echo $this->Form->input("Board.title",["label"=>"タイトル"]);
        echo $this->Form->input("Board.description",["label"=>"説明"]);
        echo $this->Form->End("追加");
    ?>
</div>
