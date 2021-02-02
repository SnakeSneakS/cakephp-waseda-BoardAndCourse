
<body>
    
    <h2>学科選択登録</h2>

    <?php 
    //for debug including image by ignore image(image is too big data)

    //debug($userDepartmentSelections[0]);
    //debug($availableDepartmentSelections);
    //debug($user);
    //debug($gpa);
    //debug($userDepartment);
    ?>



<p class="alert-message"> 
    <?php 
    /*
    if(empty($userDepartment["Department"]["department"])){ 
        echo $this->Html->Link("まず現在所属する学科を選択してください",["controller"=>"users","action"=>"edit",$user["User"]["id"]]); 
    } 
    else if(!empty($gpa["Gpa"]["gpa"])){ 
        echo $this->Html->Link("gpaを入力＆登録してください",["controller"=>"users","action"=>"edit",$user["User"]["id"]]); 
    }*/
    ?>
</p>


<h3>登録の手順</h3>
<ul>
    <ol>
        <li>現在所属する学科を登録</li>
        <li>最新の平均GPAを登録</li>
        <li>学科選択を登録</li>
    </ol>
</ul>
<br>


<h3>ユーザ</h3>
<?php echo $this->Html->tag("p","ユーザid： ".$user["User"]["id"]);  ?>
<?php echo $this->Html->tag("p","名前： ".$user["User"]["username"]);  ?>


<h3>現在の所属学科</h3>
<table>
    <thead>
        <th>所属学科</th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td> <?php echo $this->Html->tag("span",!empty($userDepartment["Department"]["department"])?$userDepartment["Department"]["department"]:"所属学科未選択" ); ?> </td>
            <td> <?php echo $this->Html->Link("所属学科変更はこちら",["controller"=>"users","action"=>"edit",$user["User"]["id"]]); ?></td>
        </tr>
    </tbody>
</table>


<h3>最新の平均GPA</h3>
<table>
    <thead>
        <th>GPA</th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <?php echo $this->Form->create(["url"=>["controller"=>"DepartmentSelections","action"=>"edit_gpa",$user["User"]["id"]], ]); ?>
            <?php echo $this->Form->hidden("Gpa.id",["default"=>$user["User"]["id"], ]) ?>
            <td> <?php echo $this->Form->input("Gpa.gpa",["label"=>"","default"=>!empty($gpa["Gpa"]["gpa"])?$gpa["Gpa"]["gpa"]:null , ])  ?> </td>
            <td> <?php echo $this->Form->end("登録") ?> </td>
        </tr>
    </tbody>
</table>

<h3>志望学科</h3>
<table>
    <thead>            
        <th>志望順位</th>
        <th>現在の学科</th>
        <th>志望する学科</th>
        <th></th>
    </thead>  
    <tbody>
        <?php for($i=0;$i<count($availableDepartmentSelections) && $i<1+count($userDepartmentSelections);$i++) : ?>
        <?php if(empty($gpa["Gpa"]["gpa"]) ){echo $this->Html->tag("td", $this->Html->tag("div","gpaを入力&登録してください",["class"=>"alert-message"]) ); continue;} ?>
        <tr>
            <?php echo $this->Form->create("UserDepartmentSelection",["url"=>["controller"=>"departmentSelections","action"=>"selection_add",$user["User"]["id"] ] ]) ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.id",array("default"=>!empty($userDepartmentSelections[$i]["UserDepartmentSelection"]["id"])?$userDepartmentSelections[$i]["UserDepartmentSelection"]["id"]:null )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.user_id",array("default"=>!empty($userDepartmentSelections[$i]["UserDepartmentSelection"]["user_id"])?$userDepartmentSelections[$i]["UserDepartmentSelection"]["user_id"]:$user["User"]["id"] )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.rank",array("default"=>$i+1 )); ?>
            <?php echo $this->Form->hidden("UserDepartmentSelection.now_department_id",array("label"=>"","default"=>!empty($userDepartment["Department"]["id"])?$userDepartment["Department"]["id"]:null )); ?>
            <td> <?php echo $this->Html->tag("span",$i+1); ?> </td>
            <td> <?php echo $this->Html->tag("span",!empty($userDepartment["Department"]["department"])?$userDepartment["Department"]["department"]:$this->Html->Link("学科を選択してください",["controller"=>"users","action"=>"edit",$user["User"]["id"]]) ); ?> </td>
            <td> <?php echo $this->Form->input("UserDepartmentSelection.next_department_id",array("label"=>"","class"=>"nextDepartmentInputArea")); ?> </td>
            <td> <?php echo $this->Form->end("登録") ?> </td>
        </tr>         
        <?php endfor ?>
    </tbody>
</table>

<div>
<?php 
if(count($userDepartmentSelections)!=0){
    echo $this->Form->create("UserDepartmentSelection",["url"=>["controller"=>"DepartmentSelections","action"=>"selection_delete_all",$user["User"]["id"] ]]);
    echo $this->Form->hidden("UserDepartmentSelection.user_id",["default"=>$user["User"]["id"]]);
    echo $this->Form->end("学科選択を消去");
}
 ?>
</div>

<?php if(count($availableDepartmentSelections)==0) echo "<p class='alert-message'> あなたの学科「".$userDepartment["Department"]["department"]."」には選択できる学科が存在しません. </p>"; ?>


<h3> <?php echo $this->Html->Link("登録状態確認ページへ移動する",["action"=>"user_view",$user["User"]["id"]]); ?> </h3>




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




