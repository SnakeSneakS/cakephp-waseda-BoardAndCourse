<?php //debug($board_base); debug($boards); debug($comments); ?>



<div class="board_base">
    <div> 
        <?php echo ($board_base["Board"]["to_board_id"]==$board_base["Board"]["id"])?"":$this->Html->Link($board_base["ToBoard"]["title"].">",["action"=>"view",$board_base["ToBoard"]["id"]]) ; ?> 
    </div>
    <div class="board_title">
        <?php echo $board_base["Board"]["title"]; ?>: 
    </div>
    <div class="board_description">
        <?php echo $board_base["Board"]["description"]; ?>
    </div>
</div>



<div>
    <div>
        <button class="add_board">
            <?php if($board_base["Board"]["allow_board_to"]==true) echo $this->Html->Link("板追加",["action"=>"add",$board_base["Board"]["id"]]); ?>
        </button>
    </div>
    <div>
        <button class="add_comment">
            <?php if($board_base["Board"]["allow_comment_to"]==true) echo $this->Html->Link("コメント追加",["controller"=>"comments","action"=>"add",$board_base["Board"]["id"]]); ?>
        </button>
        <div>
            <?php /*if($board_base["Board"]["allow_comment_to"]==true){
                    echo $this->Form->create("Comment",["url"=>["controller"=>"comments","action"=>"add",$board_base["Board"]["id"]] ] ); 
                    echo $this->Form->hidden("Comment.user_id",["default"=>-1]);
                    echo $this->Form->hidden("Comment.to_board_id",["default"=>$board_base["Board"]["id"]] );
                    //echo $this->Form->input("Comment.to_comment_id",["default"=>null]);
                    echo $this->Form->input("Comment.text");
                    echo $this->Form->End("コメント送信");
                } */
            ?>
        </div>
    </div>
</div>



<div class="boards_area">
    <?php foreach($boards as $board): ?>
    <?php if($board["Board"]["id"]==$board_base["Board"]["id"]){ continue; } ?>
    <div class="board">
        <div>
            <span class="board_link"> <?php echo $this->html->link($board["Board"]["title"],["controller"=>"boards","action"=>"view",$board["Board"]["id"]]);?> </span>
            <span class="small"> <?php echo $board["Board"]["modified"]; ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="comments_area">
    <?php foreach($comments as $comment): ?>
    <div class="comment" id="comment_<?php echo $comment["Comment"]["id"];?>">
        <div>
            <div class="comment_top">
                <span class="comment_user"> <?php echo $this->Html->Link($comment["User"]["username"]?$comment["User"]["username"]:"unknown",["controller"=>"users","action"=>"view",$comment["User"]["id"] ]); ?> </span>
                <span class="small"> <?php echo $comment["Comment"]["created"]; ?></span>  
            </div>
            <div class="comment_text">
                <span> <?php echo $comment["Comment"]["text"] ?> </span>
            </div>      
        </div>
    </div>
    <?php endforeach; ?>
</div>
