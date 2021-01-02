<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users index</title>
</head>
<body>
    <h2>Admin: Users index</h2>

    <?php echo $this->Html->Link("index",array("action"=>"index")) ?>

    <?php 
        //blobはデータ量多いからdebugで表示されない？debugで表示される様にblobデータをnullにしている
        //debug($departments[0]); 
    ?>

    <h3>department</h3>
    <table>
        <thead>
            <th>id</th>
            <th>department</th>
            <th>delete</th>
            <th></th>
        </thead>   
        <?php foreach ($departments as $department) : ?>
            <tr>
                <?php echo $this->Form->create("Department") ?>
                <?php echo $this->Form->hidden("Department.id",array("default"=>$department["Department"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$department["Department"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("Department.department",array("default"=>$department["Department"]["department"],"type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("Department.delete",array("value"=>true,"hiddenFiekd"=>"N")) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!--
            新規追加
        <tr>
            <?php echo $this->Form->create("Department") ?>
            <?php echo $this->Form->hidden("Department.id",array("default"=>1+$departments[count($departments)-1]["Department"]["id"]) ); ?>
            <td> <?php echo $this->Html->tag("span",1+$departments[count($departments)-1]["Department"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("Department.department",array("default"=>"これは一通り作り終わったら消す","type"=>"text","label"=>"")); ?> </td>
            <td> <?php echo $this->Form->checkbox("Department.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("New") ?> </td>
        </tr>  
        -->

    </table>

</body>
</html>




