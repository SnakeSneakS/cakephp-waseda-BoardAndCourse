<h2>add user</h2>

<?php
echo $this->Form->create("User");
echo $this->Form->input("name");
echo $this->Form->input("password");
//echo $this->Form->input("body",array("rows"=>3));//3行のtextarea optionを追加することで見た目を整える
echo $this->Form->end("Save");
?>