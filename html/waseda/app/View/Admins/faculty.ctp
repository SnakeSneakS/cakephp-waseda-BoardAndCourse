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
        //debug($faculties[0]); 
    ?>

    <h3>Faculty</h3>
    <table>
        <thead>
            <th>id</th>
            <th>Faculty</th>
            <th>delete</th>
            <th></th>
        </thead>   
        <?php foreach ($faculties as $faculty) : ?>
            <tr>
                <?php echo $this->Form->create("Faculty") ?>
                <?php echo $this->Form->hidden("Faculty.id",array("default"=>$faculty["Faculty"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$faculty["Faculty"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("Faculty.faculty",array("default"=>$faculty["Faculty"]["faculty"],"type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("Faculty.delete",array("value"=>true,"hiddenFiekd"=>"N")) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加
        <tr>
            <?php echo $this->Form->create("Faculty") ?>
            <?php echo $this->Form->hidden("Faculty.id",array("default"=>1+$faculties[count($faculties)-1]["Faculty"]["id"]) ); ?>
            <td> <?php echo $this->Html->tag("span",1+$faculties[count($faculties)-1]["Faculty"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("Faculty.faculty",array("default"=>"これは一通り作り終わったら消す","type"=>"text","label"=>"")); ?> </td>
            <td> <?php echo $this->Form->checkbox("Faculty.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("New") ?> </td>
        </tr>  
        -->

    </table>

</body>
</html>




