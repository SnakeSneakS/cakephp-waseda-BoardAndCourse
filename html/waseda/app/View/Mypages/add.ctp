<h2>add user</h2>

<?php
echo $this->Form->create("User");
echo $this->Form->input("name");
echo $this->Form->input("password");
echo $this->Form->end("Save");
?>
