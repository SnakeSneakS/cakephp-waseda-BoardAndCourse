<div class="ログイン">
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo 'ログイン：'; ?>
        </legend>
        <?php echo $this->Form->input('username',["label"=>"ユーザネーム"]);
        echo $this->Form->input('password',["label"=>"パスワード"]);
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>
