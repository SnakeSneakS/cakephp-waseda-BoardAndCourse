
<body>
    
<h2>学科選択（登録済み）</h2>

    <?php 
    //for debug including image by ignore image(image is too big data)

    //debug($userDepartmentSelections[0]);
    //debug($availableDepartmentSelections);
    //debug($user);
    //debug($gpa);
    //debug($userDepartment);
    ?>


<h3>所属学科</h3>
<p>
<?php echo $this->Html->tag("span",!empty($userDepartment["Department"]["department"])?$userDepartment["Department"]["department"]:"未登録" ); ?> 
</p>

<h3>最新の平均GPA</h3>
<?php echo $this->Html->tag("span",!empty($gpa["Gpa"]["gpa"])?$gpa["Gpa"]["gpa"]:"未登録" )  ?>


<h3>志望学科</h3>
<table>
    <thead>            
        <th>志望順位</th>
        <th>現在の学部</th>
        <th>志望する学部</th>
        <th></th>
    </thead>  
    <tbody>
        <?php foreach($userDepartmentSelections as $userDepartmentSelection) : ?>
        <tr>
            <td> <?php echo $this->Html->tag("span",$userDepartmentSelection["UserDepartmentSelection"]["rank"]); ?> </td>
            <td> <?php echo $this->Html->tag("span",$userDepartmentSelection["NowDepartment"]["department"] ); ?> </td>
            <td> <?php echo $this->Html->tag("span",$userDepartmentSelection["NextDepartment"]["department"] ); ?> </td>
        </tr>         
        <?php endforeach ?>
    </tbody>
</table>

<p> <?php if(empty($userDepartmentSelections)) echo $this->Html->tag("span","未登録");?> </p>

<h3> <?php echo $this->Html->Link("登録ページへ移動する",["action"=>"user_add",$user["User"]["id"]]); ?> </h3>



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



