<div>
    <?php 
        echo $this->Form->create("Comment",["url"=>["controller"=>"comments","action"=>"add",$to_board_id] ] ); 
        echo $this->Form->hidden("Comment.user_id",["default"=>!empty($login_id)?$login_id:null] );
        echo $this->Form->hidden("Comment.to_board_id",["default"=>!empty($to_board_id)?$to_board_id:null] );
        //echo $this->Form->input("Comment.to_comment_id",["default"=>null]);
        echo $this->Form->input("Comment.text");
        echo $this->Form->End("コメント送信");
    ?>
</div>