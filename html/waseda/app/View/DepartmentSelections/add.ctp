
<body>
    
    <h2>学部選択登録</h2>

    <?php 
    //for debug including image by ignore image(image is too big data)

    //debug($userDepartmentSelections[0]);
    //debug($availableDepartmentSelections);
    //debug($user);
    //debug($gpa);
    //debug($userDepartment);
    ?>

<p>
<?php echo $this->Html->Link("学部変更などはここから",["controller"=>"Mypages","action"=>"edit",$user["User"]["id"]]); ?>
</p>

<p class="alert-message">
<?php
if(empty($userDepartment["Department"]["department"])){
    echo $this->Html->Link("Please set your department",["controller"=>"Mypages","action"=>"edit",$user["User"]["id"]]);
}
?>
</p>

<h3> Set your GPA</h3>
<table>
    <thead>
        <th>Your GPA</th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <?php echo $this->Form->create(["url"=>["controller"=>"DepartmentSelections","action"=>"editGpa"] ]); ?>
            <?php echo $this->Form->hidden("Gpa.id",["default"=>$user["User"]["id"], ]) ?>
            <td> <?php echo $this->Form->input("Gpa.gpa",["label"=>"","default"=>!empty($gpa["Gpa"]["gpa"])?$gpa["Gpa"]["gpa"]:null , ])  ?> </td>
            <td> <?php echo $this->Form->end("change") ?> </td>
        </tr>
    </tbody>
</table>

<h3> Set your selection </h3>
<table>
    <thead>            
        <th>志望順位</th>
        <th>現在の学部</th>
        <th>志望する学部</th>
        <th></th>
    </thead>  
    <tbody>
        <?php for($i=0;$i<count($availableDepartmentSelections);$i++) : ?>
        <tr>
            <?php echo $this->Form->create("UserDepartmentSelection") ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.id",array("default"=>!empty($userDepartmentSelections[$i]["UserDepartmentSelection"]["id"])?$userDepartmentSelections[$i]["UserDepartmentSelection"]["id"]:null )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.user_id",array("default"=>!empty($userDepartmentSelections[$i]["UserDepartmentSelection"]["user_id"])?$userDepartmentSelections[$i]["UserDepartmentSelection"]["user_id"]:$user["User"]["id"] )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.rank",array("default"=>$i+1 )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.now_department_id",array("label"=>"","default"=>!empty($userDepartment["Department"]["id"])?$userDepartment["Department"]["id"]:null )); ?>
            <td> <?php echo $this->Html->tag("span",$i+1); ?> </td>
            <td> <?php echo $this->Html->tag("span",!empty($userDepartment["Department"]["department"])?$userDepartment["Department"]["department"]:null ); ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->end("change") ?> </td>
        </tr>         
        <?php endfor ?>
    </tbody>
</table>
<?php if(count($availableDepartmentSelections)==0) echo "<p class='alert-message'> Your department ".$userDepartment["Department"]["department"]." doesn't have next department options. </p>"; ?>





<?php echo $this->Html->script("options",array("inline"=>false)); ?>

<script>
    let userDepartmentSelections=<?php echo json_encode($userDepartmentSelections) ?>;
    let availableDepartmentSelections=<?php echo json_encode($availableDepartmentSelections) ?>;
    //console.log(availableDepartmentSelections);
    
    nextAvailableDepartments=EncodeJsonForOption(availableDepartmentSelections,"NextDepartment","department","id");

    let nextDepartmentInputAreas=document.getElementsByClassName("nextDepartmentInputArea");
    for(let i=0;i<nextDepartmentInputAreas.length;i++){
        //CreateOptions(nowDepartmentInputAreas[i],nowAvailableDepartments,i<userDepartmentSelections.length?userDepartmentSelections[i]["UserDepartmentSelection"]["now_department_id"]:-1);
        CreateOptions(nextDepartmentInputAreas[i],nextAvailableDepartments,i<userDepartmentSelections.length?userDepartmentSelections[i]["UserDepartmentSelection"]["next_department_id"]:-1);
    }
    
</script>

</body>
</html>




