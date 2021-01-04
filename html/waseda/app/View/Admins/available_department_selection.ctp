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

    <h3>AvailableDepartmentSelection</h3>
    <table>
        <thead>
            <th>id</th>
            <th>school</th>
            <th>now department</th>
            <th>next department</th>
            <th>max_num</th>
            <th>delete</th>
            <th></th>
        </thead>  
        
        <?php foreach ($availableDepartmentSelections as $availableDepartmentSelection) : ?>
            <tr>
                <?php echo $this->Form->create("AvailableDepartmentSelection") ?>
                <?php echo $this->Form->hidden("AvailableDepartmentSelection.id",array("default"=>$availableDepartmentSelection["AvailableDepartmentSelection"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$availableDepartmentSelection["AvailableDepartmentSelection"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("AvailableDepartmentSelection.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("AvailableDepartmentSelection.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"departmentInputArea")); ?> 
                <td> <?php echo $this->Form->input("AvailableDepartmentSelection.now_department_id",array("label"=>"","class"=>"nowDepartmentInputArea")); ?> </td>
                <td> <?php echo $this->Form->input("AvailableDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
                <td> <?php echo $this->Form->input("AvailableDepartmentSelection.max_num",array("default"=>$availableDepartmentSelection["AvailableDepartmentSelection"]["max_num"],"label"=>"")); ?> </td>
                <td> <?php echo $this->Form->checkbox("AvailableDepartmentSelection.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加つき
        <tr>
            <?php echo $this->Form->create("AvailableDepartmentSelection") ?>
            <?php echo $this->Form->hidden("AvailableDepartmentSelection.id",array("default"=>1+$availableDepartmentSelections[count($availableDepartmentSelections)-1]["AvailableDepartmentSelection"]["id"])); ?>
            <td> <?php echo $this->Html->tag("span",1+$availableDepartmentSelections[count($availableDepartmentSelections)-1]["AvailableDepartmentSelection"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("AvailableDepartmentSelection.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("AvailableDepartmentSelection.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"departmentInputArea")); ?> 
            <td> <?php echo $this->Form->input("AvailableDepartmentSelection.now_department_id",array("label"=>"","class"=>"nowDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->input("AvailableDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->input("AvailableDepartmentSelection.max_num",array("default"=>0,"label"=>"")); ?> </td>
            <td> <?php echo $this->Form->checkbox("AvailableDepartmentSelection.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("new") ?> </td>
        </tr>   
        -->
        

    </table>
    
    <?php echo $this->Html->script("options",array("inline"=>false)); ?>
    <script>
        let AvailableDepartmentSelections=<?php echo json_encode($availableDepartmentSelections) ?>;
        let schools=<?php echo json_encode($schools) ?>;
        let departments=<?php echo json_encode($departments) ?>;
        
        schools=EncodeJsonForOpinion(schools,"School","school","id");
        departments=EncodeJsonForOpinion(departments,"Department","department","id");

        console.log(departments);

        //display available schools first //nowCourseInputArea
        let schoolInputAreas=document.getElementsByClassName("schoolInputArea");
        let nowDepartmentInputAreas=document.getElementsByClassName("nowDepartmentInputArea");
        let nextDepartmentInputAreas=document.getElementsByClassName("nextDepartmentInputArea");
        for(let i=0;i<schoolInputAreas.length;i++){
            CreateOptions(schoolInputAreas[i],schools,i<AvailableDepartmentSelections.length?AvailableDepartmentSelections[i]["AvailableDepartmentSelection"]["school_id"]:-1);
            CreateOptions(nowDepartmentInputAreas[i],departments,i<AvailableDepartmentSelections.length?AvailableDepartmentSelections[i]["AvailableDepartmentSelection"]["now_department_id"]:-1);
            CreateOptions(nextDepartmentInputAreas[i],departments,i<AvailableDepartmentSelections.length?AvailableDepartmentSelections[i]["AvailableDepartmentSelection"]["next_department_id"]:-1);
        }
        
    </script>

</body>
</html>




