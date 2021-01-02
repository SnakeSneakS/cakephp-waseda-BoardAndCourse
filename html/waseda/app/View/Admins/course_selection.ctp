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
    /*
        //departmentのselectのoptionをcakephpで作る場合
        $departmentKV;//optionで選択する
        foreach($departments as $department){
            $departmentKV[$department["Department"]["id"]]=$department["Department"]["department"];
        }
        debug($departmentKV);
    */
    ?>

<?php /*
    //index of course & index of department
    <h3>course</h3>
    <table>
        <thead>
            <th>id</th>
            <th>course</th>
        </thead>   
        <?php foreach ($courses as $course) : ?>
            <tr>
                <td> <?php echo $this->Html->tag("span",$course["Course"]["id"]) ?> </td>
                <td> <?php echo $this->Html->tag("span",$course["Course"]["course"]); ?> </td>
            </tr>         
        <?php endforeach ?>
    </table>  
    <h3>department</h3>
    <table>
        <thead>
            <th>id</th>
            <th>department</th>
        </thead>   
        <?php foreach ($departments as $department) : ?>
            <tr>
                <td> <?php echo $this->Html->tag("span",$department["Department"]["id"]) ?> </td>
                <td> <?php echo $this->Html->tag("span",$department["Department"]["department"]); ?> </td>
            </tr>         
        <?php endforeach ?>
*/?>


    <h3>courseSelection</h3>
    <table>
        <thead>
            <th>id</th>
            <th>department</th>
            <th>now course</th>
            <th>next course</th>
            <th>max_num</th>
            <th>delete</th>
            <th></th>
        </thead>  
        
        <?php foreach ($courseSelections as $courseSelection) : ?>
            <tr>
                <?php echo $this->Form->create("CourseSelection") ?>
                <?php echo $this->Form->hidden("CourseSelection.id",array("default"=>$courseSelection["CourseSelection"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$courseSelection["CourseSelection"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("CourseSelection.department_id",array("label"=>"","options"=>array(),"class"=>"departmentInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("CourseSelection.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"departmentInputArea")); ?> 
                <td> <?php echo $this->Form->input("CourseSelection.now_course_id",array("default"=>$courseSelection["NowCourse"]["id"],"label"=>"", "empty"=>"(choose one)")); ?> </td>
                <td> <?php echo $this->Form->input("CourseSelection.next_course_id",array("default"=>$courseSelection["NextCourse"]["id"],"label"=>"", "empty"=>"(choose one)")); ?> </td>
                <td> <?php echo $this->Form->input("CourseSelection.max_num",array("default"=>$courseSelection["CourseSelection"]["max_num"],"label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("CourseSelection.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!--
            新規追加つき
        <tr>
                <?php echo $this->Form->create("CourseSelection") ?>
                <?php echo $this->Form->hidden("CourseSelection.id",array("default"=>$courseSelection["CourseSelection"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",count($courseSelections)) ?> </td>
                <td> <?php echo $this->Form->input("Department.department",array("default"=>"","type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->input("Department.department",array("default"=>"","type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->input("Department.department",array("default"=>"","type"=>"text","label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("CourseSelection.delete",array("value"=>true,"hidden"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
        </tr>  
        -->
        

    </table>
    
    <?php echo $this->Html->script("options",array("inline"=>false)); ?>
    <script>
        let courseSelections=<?php echo json_encode($courseSelections) ?>;
        let courses=<?php echo json_encode($courses) ?>;
        let departments=<?php echo json_encode($departments) ?>;
        
        console.log( EncodeJsonForOpinion(courses) );

        //display available departments first
        let departmentInputAreas=document.getElementsByClassName("departmentInputArea");
        for(let i=0;i<departmentInputAreas.length;i++){
            CreateOptions(departmentInputAreas[i],departments,"Department","department","id",courseSelections[i]["CourseSelection"]["department_id"]);
        }
        
    </script>

</body>
</html>



