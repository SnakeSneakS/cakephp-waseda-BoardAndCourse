<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
echo $this->Html->link("user index",array("action"=>"user"));
?>

<h2>Admin: edit user</h2>

<?php //debug($user); ?>

<?php
echo $this->Form->create("User",array(/*"enctype"=>"multipart/form-data"*/"type"=>"file"));
echo $this->Html->tag("h3","Basic");
echo $this->Form->hidden("User.id",array("default"=>$user["User"]["id"]));
echo $this->Form->input("User.name",array("default"=>$user["User"]["name"]));
echo $this->Form->input("User.password",array("default"=>$user["User"]["password"]));
//echo $this->Form->end("Save");

//echo $this->Form->create("Profile"); //これのかわり（？）にProfile.をnameに付けたらいい
echo $this->Html->tag("h3","Additional"/*,array("class"=>"sub-title")*/ );
echo $this->Form->hidden("Profile.user_id",array("default"=>$user["User"]["id"]));
echo $this->Form->input("Profile.enter_year",array("default"=>$user["Profile"]["enter_year"],"type"=>"number","step"=>"1","min"=>date("Y")-10,"max"=>date("Y"),"placeholder"=>(date("Y")-3)." ~ ".date("Y") )); //echo $this->Form->input("enter_year",array("type"=>"date","dateFormat"=>"Y","minYear"=>date("Y")-3,"maxYear"=>date("Y") ));
//departmentを選択し、それをselectしてidにする
//courseを選択し、それをselectしてidにする
/* ONE_TIME_FOR_TEST */
echo $this->Form->input("Profile.faculty_id",array("default"=>$user["Profile"]["faculty_id"],"placeholder"=>"学術院","class"=>"FacultyInputArea" ));
echo $this->Form->input("Profile.school_id",array("default"=>$user["Profile"]["school_id"],"placeholder"=>"学部","class"=>"SchoolInputArea"));
echo $this->Form->input("Profile.department_id",array("default"=>$user["Profile"]["department_id"],"placeholder"=>"学科","class"=>"DepartmentInputArea" ));
echo $this->Form->input("Profile.comment",array("default"=>$user["Profile"]["comment"]));
echo $this->Form->input("Profile.image",array("default"=>$user["Profile"]["image"],'label' => "profile-image", 'type' => 'file', 'multiple'));
echo('<img src="data:image/jpg;base64,'.base64_encode($user["Profile"]["image"]).'" height="300px"/>');
//echo $this->Html->image("data:image/jpg;base64,".base64_encode($user["Profile"]["image"]), array("alt"=>"profile image","height"=>"100px") );
/* ONE_TIME_FOR_TEST */
echo $this->Form->input("Profile.gpa",array("default"=>$user["Profile"]["gpa"],"type"=>"number","step"=>"0.001","min"=>0,"max"=>4));
echo $this->Form->end("Save");
?>

<?php echo $this->Html->script("options",array("inline"=>false)); ?>
<script>
let user=<?php $user["Profile"]["image"]=null; echo json_encode($user); ?>;
let faculties=<?php echo json_encode($faculties) ?>;
let schools=<?php echo json_encode($schools) ?>;
let departments=<?php echo json_encode($departments) ?>;

faculties=EncodeJsonForOpinion(faculties,"Faculty","faculty","id");
schools=EncodeJsonForOpinion(schools,"School","school","id");
departments=EncodeJsonForOpinion(departments,"Department","department","id");

console.log(departments);

//display options
let facultyInputAreas=document.getElementsByClassName("FacultyInputArea");
let schoolInputAreas=document.getElementsByClassName("SchoolInputArea");
let departmentInputAreas=document.getElementsByClassName("DepartmentInputArea");
CreateOptions(facultyInputAreas[0],faculties,user["Profile"]["faculty_id"]?user["Profile"]["faculty_id"]:-1);
CreateOptions(schoolInputAreas[0],schools,user["Profile"]["school_id"]?user["Profile"]["school_id"]:-1);
CreateOptions(departmentInputAreas[0],departments,user["Profile"]["department_id"]?user["Profile"]["department_id"]:-1);

</script>