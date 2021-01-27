<div>
    <?php 
        echo $this->Form->create("Comment",["url"=>["controller"=>"comments","action"=>"add",$toId] ] ); 
        echo $this->Form->hidden("Comment.user_id",["default"=>-1]);
        echo $this->Form->hidden("Comment.to_board_id",["default"=>$toId] );
        //echo $this->Form->input("Comment.to_comment_id",["default"=>null]);
        echo $this->Form->input("Comment.text");
        echo $this->Form->End("コメント送信");
    ?>
</div>