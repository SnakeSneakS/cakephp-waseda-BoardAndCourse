<?php //debug($board); debug($users); ?>


<div class="board_base">
    <div> 
        <div>
            <?php echo ($board["Board"]["to_board_id"]==$board["Board"]["id"])?"":$this->Html->Link($board["ToBoard"]["title"].">",["action"=>"view",$board["ToBoard"]["id"]]) ; ?> 
        </div>
        <div class="small right m5"> 
            <p> created by: <?php echo $this->Html->Link($board["User"]["username"], ["controller"=>"users","action"=>"view",$board["User"]["id"]] );?>  </p>
            <p> <?php echo empty($login_id)?"":"watching: ".$this->Html->Link("users",["controller"=>"BoardUsers","action"=>"board",$board["Board"]["id"]]); ?>  </p>
        </div>
    </div>
    
    <div class="board_title">
        <span>
            <?php echo $board["Board"]["title"]; ?>: 
        </span>
    </div>
    <div class="board_description">
        <?php echo nl2br( $board["Board"]["description"] ); ?>
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
                echo $this->Form->hidden("board_id",["default"=>$board["Board"]["id"], ]);
                echo $this->Form->hidden("type",["default"=>"watch", ]);
                echo $this->Form->end("WATCH"); 
            }
        ?>
    </div>
</div>



<div>
    <h2>
        watching users: 
    </h2>
    <ul>
        <?php foreach($users as $user): ?>
        <li>
            <?php echo $this->Html->Link($user["User"]["username"] , ["controller"=>"users", "action"=>"view", $user["User"]["id"] ]); ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>