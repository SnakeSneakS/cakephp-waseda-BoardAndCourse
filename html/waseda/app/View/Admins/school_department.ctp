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
    //debug($schoolDepartments);
    /*
        //departmentのselectのoptionをcakephpで作る場合
        $schoolDepartmentKV;//optionで選択する
        foreach($schoolDepartments as $schoolDepartment){
            $schoolDepartmentKV[$schoolDepartment["Department"]["id"]]=$schoolDepartment["Department"]["department"];
        }
        debug($schoolDepartmentKV);
    */
    ?>

    <h3>SchoolDepartment</h3>
    <table>
        <thead>
            <th>id</th>
            <th>school</th>
            <th>department</th>
            <th>delete</th>
            <th></th>
        </thead>  
        
        <?php foreach ($schoolDepartments as $schoolDepartment) : ?>
            <tr>
                <?php echo $this->Form->create("SchoolDepartment") ?>
                <?php echo $this->Form->hidden("SchoolDepartment.id",array("default"=>$schoolDepartment["SchoolDepartment"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$schoolDepartment["SchoolDepartment"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("SchoolDepartment.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("SchoolDepartment.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"departmentInputArea")); ?> 
                <td> <?php echo $this->Form->input("SchoolDepartment.now_department_id",array("label"=>"","class"=>"departmentInputArea")); ?> </td>
                <td> <?php echo $this->Form->checkbox("SchoolDepartment.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加つき
        <tr>
            <?php echo $this->Form->create("SchoolDepartment") ?>
            <?php echo $this->Form->hidden("SchoolDepartment.id",array("default"=>1+$schoolDepartments[count($schoolDepartments)-1]["SchoolDepartment"]["id"])); ?>
            <td> <?php echo $this->Html->tag("span",1+$schoolDepartments[count($schoolDepartments)-1]["SchoolDepartment"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("SchoolDepartment.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("SchoolDepartment.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"departmentInputArea")); ?> 
            <td> <?php echo $this->Form->input("SchoolDepartment.department_id",array("label"=>"","class"=>"departmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->checkbox("SchoolDepartment.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("new") ?> </td>
        </tr>   
        -->
        

    </table>
    
    <?php echo $this->Html->script("options",array("inline"=>false)); ?>
    <script>
        let SchoolDepartments=<?php echo json_encode($schoolDepartments) ?>;
        let schools=<?php echo json_encode($schools) ?>;
        let departments=<?php echo json_encode($departments) ?>;
        
        schools=EncodeJsonForOption(schools,"School","school","id");
        departments=EncodeJsonForOption(departments,"Department","department","id");

        console.log(departments);

        //display available schools first //nowCourseInputArea
        let schoolInputAreas=document.getElementsByClassName("schoolInputArea");
        let departmentInputAreas=document.getElementsByClassName("departmentInputArea");
        for(let i=0;i<schoolInputAreas.length;i++){
            CreateOptions(schoolInputAreas[i],schools,i<SchoolDepartments.length?SchoolDepartments[i]["SchoolDepartment"]["school_id"]:-1);
            CreateOptions(departmentInputAreas[i],departments,i<SchoolDepartments.length?SchoolDepartments[i]["SchoolDepartment"]["department_id"]:-1);
        }
        
    </script>

</body>
</html>




