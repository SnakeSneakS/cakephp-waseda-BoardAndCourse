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
        //debug($courses[0]); 
    ?>

    <h3>Course</h3>
    <table>
        <thead>
            <th>id</th>
            <th>course</th>
            <th>delete</th>
            <th></th>
        </thead>   
        <?php foreach ($courses as $course) : ?>
            <tr>
                <?php echo $this->Form->create("Course") ?>
                <?php echo $this->Form->hidden("Course.id",array("default"=>$course["Course"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$course["Course"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("Course.course",array("default"=>$course["Course"]["course"],"type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("Course.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!--
            新規追加
        <tr>
            <?php echo $this->Form->create("Course") ?>
            <?php echo $this->Form->hidden("Course.id",array("default"=>count($courses)) ); ?>
            <td> <?php echo $this->Html->tag("span",count($courses)) ?> </td>
            <td> <?php echo $this->Form->input("Course.course",array("default"=>"これは一通り作り終わったら消す","type"=>"text","label"=>"")); ?> </td>
            <td> <?php echo $this->Form->checkbox("Course.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("New") ?> </td>
        </tr>  
        -->

    </table>

</body>
</html>




