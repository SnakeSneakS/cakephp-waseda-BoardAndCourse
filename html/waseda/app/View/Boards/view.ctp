<?php //debug($board_base); debug($boards); debug($comments); ?>

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
    <span class="right">
        <?php 
        if(!empty($login_id)) echo $this->Html->Link("検索",["action"=>"search"]);
        ?>
    </span>
</div>



<div class="board_base">
    <div> 
        <div>
            <?php echo ($board_base["Board"]["to_board_id"]==$board_base["Board"]["id"])?"":$this->Html->Link($board_base["ToBoard"]["title"].">",["action"=>"view",$board_base["ToBoard"]["id"]]) ; ?> 
        </div>
        <div class="small right m5"> 
            <p> created by: <?php echo $this->Html->Link($board_base["User"]["username"], ["controller"=>"users","action"=>"view",$board_base["User"]["id"]] );?>  </p>
            <p> <?php echo empty($login_id)?"":"watching: ".$this->Html->Link("users",["controller"=>"BoardUsers","action"=>"board",$board_base["Board"]["id"]]); ?>  </p>
        </div>
    </div>
    
    <div class="board_title">
        <span>
            <?php echo $board_base["Board"]["title"]; ?>: 
        </span>
    </div>
    <div class="board_description">
        <?php echo nl2br( $board_base["Board"]["description"] ); ?>
    </div>
    <div class="board_user">
        <?php 
            if(isset($board_user["BoardUser"]["type"]) && $board_user["BoardUser"]["type"]==="watch"){
                echo $this->Form->create("BoardUser",["url"=>["controller"=>"BoardUsers","action"=>"delete"]]);
                echo $this->Form->hidden("user_id",["default"=>$board_user["BoardUser"]["user_id"], ] );
                echo $this->Form->hidden("board_id",["default"=>$board_user["BoardUser"]["board_id"], ]);
                echo $this->Form->end("QUIT WATCH"); 
            }else if(!empty($login_id)){
                echo $this->Form->create("BoardUser",["url"=>["controller"=>"BoardUsers","action"=>"add"]]);
                echo $this->Form->hidden("user_id",["default"=>$login_id, ]);
                echo $this->Form->hidden("board_id",["default"=>$board_base["Board"]["id"], ]);
                echo $this->Form->hidden("type",["default"=>"watch", ]);
                echo $this->Form->end("WATCH"); 
            }
        ?>
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
                <span> <?php echo nl2br( $comment["Comment"]["text"] ); ?> </span>
            </div>      
        </div>
    </div>
    <?php endforeach; ?>
</div>
