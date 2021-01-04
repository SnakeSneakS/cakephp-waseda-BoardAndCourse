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
    //for debug including image by ignore image(image is too big data)
    /*/
    $num=count($userDepartmentSelections);
    for($i=0;$i<$num;$i++){ 
        //echo($userDepartmentSelections[$i]["User"]["Profile"]["image"]); 
        $userDepartmentSelections[$i]["User"]["Profile"]["image"]=null; 
    } 
    debug($userDepartmentSelections[0]);
    */
    ?>

    <h3>UserDepartmentSelection</h3>
    <table>
        <thead>
            <th>id</th>
            <th>user_id</th>
            <th>rank</th>
            <th>now department</th>
            <th>next department</th>
            <th>delete</th>
            <th></th>
        </thead>  
        
        <?php foreach ($userDepartmentSelections as $userDepartmentSelection) : ?>
            <tr>
                <?php echo $this->Form->create("UserDepartmentSelection") ?>
                <?php echo $this->Form->hidden("UserDepartmentSelection.id",array("default"=>$userDepartmentSelection["UserDepartmentSelection"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$userDepartmentSelection["UserDepartmentSelection"]["id"]) ?> </td>
                <?php echo $this->Form->hidden("UserDepartmentSelection.user_id",array("default"=>$userDepartmentSelection["UserDepartmentSelection"]["user_id"])); ?>
                <td> <?php echo $this->Html->tag("span",$userDepartmentSelection["UserDepartmentSelection"]["user_id"]); ?> </td>
                <td> <?php echo $this->Form->input("UserDepartmentSelection.max_num",array("label"=>"","default"=>$userDepartmentSelection["UserDepartmentSelection"]["rank"])); ?> </td>
                <td> <?php echo $this->Form->input("UserDepartmentSelection.now_department_id",array("label"=>"","class"=>"nowDepartmentInputArea")); ?> </td>
                <td> <?php echo $this->Form->input("UserDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
                <td> <?php echo $this->Form->checkbox("UserDepartmentSelection.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加つき
        <tr>
            <?php echo $this->Form->create("UserDepartmentSelection") ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.id",array("default"=>1+$userDepartmentSelections[count($userDepartmentSelections)-1]["UserDepartmentSelection"]["id"])); ?>
            <td> <?php echo $this->Html->tag("span",1+$userDepartmentSelections[count($userDepartmentSelections)-1]["UserDepartmentSelection"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.user_id",array("label"=>"","type"=>"text")); ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.rank",array("label"=>"")); ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.now_department_id",array("label"=>"","class"=>"nowDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->checkbox("UserDepartmentSelection.delete",array("value"=>true, "hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("change") ?> </td>
        </tr>  
        -->
        

    </table>
    
    <?php echo $this->Html->script("options",array("inline"=>false)); ?>

    <script>
        let userDepartmentSelections=<?php echo json_encode($userDepartmentSelections) ?>;
        let availableDepartmentSelections=<?php echo json_encode($availableDepartmentSelections) ?>;
        let departments=<?php echo json_encode($departments) ?>;
        
        departments=EncodeJsonForOpinion(departments,"Department","department","id");

        console.log(availableDepartmentSelections);

        //display available departments: Key and Value
        let nowDepartmentInputAreas=document.getElementsByClassName("nowDepartmentInputArea");
        let nextDepartmentInputAreas=document.getElementsByClassName("nextDepartmentInputArea");
        for(let i=0;i<nowDepartmentInputAreas.length;i++){
            CreateOptions(nowDepartmentInputAreas[i],departments,i<userDepartmentSelections.length?userDepartmentSelections[i]["UserDepartmentSelection"]["now_department_id"]:-1);
            CreateOptions(nextDepartmentInputAreas[i],departments,i<userDepartmentSelections.length?userDepartmentSelections[i]["UserDepartmentSelection"]["next_department_id"]:-1);
        }
        
    </script>

</body>
</html>




