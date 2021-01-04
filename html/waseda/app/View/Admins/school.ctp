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
        //debug($schools[0]); 
    ?>

    <h3>School</h3>
    <table>
        <thead>
            <th>id</th>
            <th>School</th>
            <th>delete</th>
            <th></th>
        </thead>   
        <?php foreach ($schools as $school) : ?>
            <tr>
                <?php echo $this->Form->create("School") ?>
                <?php echo $this->Form->hidden("School.id",array("default"=>$school["School"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$school["School"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("School.school",array("default"=>$school["School"]["school"],"type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("School.delete",array("value"=>true,"hiddenFiekd"=>"N")) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加
        <tr>
            <?php echo $this->Form->create("School") ?>
            <?php echo $this->Form->hidden("School.id",array("default"=>1+$schools[count($schools)-1]["School"]["id"]) ); ?>
            <td> <?php echo $this->Html->tag("span",1+$schools[count($schools)-1]["School"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("School.school",array("default"=>"これは一通り作り終わったら消す","type"=>"text","label"=>"")); ?> </td>
            <td> <?php echo $this->Form->checkbox("School.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("New") ?> </td>
        </tr>  
        -->

    </table>

</body>
</html>




