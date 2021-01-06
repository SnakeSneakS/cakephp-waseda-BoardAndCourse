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
echo $this->Form->create("User",array(/*"enctype"=>"multipart/form-data"*//*"type"=>"file"*/));
echo $this->Html->tag("h3","Basic");
echo $this->Form->hidden("User.id",array("default"=>$user["User"]["id"]));
echo $this->Form->input("User.name",array("default"=>$user["User"]["name"]));
echo $this->Form->input("User.password",array("default"=>$user["User"]["password"]));
//echo $this->Form->end("Save");

//echo $this->Form->create("Profile"); //これのかわり（？）にProfile.をnameに付けたらいい
echo $this->Html->tag("h3","Additional"/*,array("class"=>"sub-title")*/ );
echo $this->Form->hidden("Profile.user_id",array("default"=>$user["User"]["id"]));
echo $this->Form->input("Profile.enter_year",array("default"=>$user["Profile"]["enter_year"],"type"=>"number","step"=>"1","min"=>date("Y")-10,"max"=>date("Y"),"placeholder"=>(date("Y")-3)." ~ ".date("Y") )); //echo $this->Form->input("enter_year",array("type"=>"date","dateFormat"=>"Y","minYear"=>date("Y")-3,"maxYear"=>date("Y") ));
echo $this->Form->input("Profile.faculty_id",array("placeholder"=>"学術院","options"=>[],"class"=>"FacultyInputArea" ));
echo $this->Form->input("Profile.school_id",array("placeholder"=>"学部","options"=>[],"class"=>"SchoolInputArea"));
echo $this->Form->input("Profile.department_id",array("placeholder"=>"学科","options"=>[],"class"=>"DepartmentInputArea" ));
echo $this->Form->input("Profile.comment",array("default"=>nl2br($user["Profile"]["comment"])));
//echo $this->Form->input("Profile.image",("type"=>"file",'label' => "profile-image", "accept"=>"image/*" ,"class"=>"imageInput")); //when send file. I decided to send imageDataUrl. type: "file" is needed when form->create
echo $this->Form->input("null",array("type"=>"file",'label' => "profile-image", "accept"=>"image/*" ,"class"=>"imageInput"));
echo $this->Form->hidden("Profile.image",array("default"=>$user["Profile"]["image"],'label' => "profile-image-data", 'type' => 'text', "accept"=>"image/*" ,"class"=>"imageDataInput"));
echo('<img class="imageOutput" src="'.$user["Profile"]["image"].'" height="300px"/>'); //when use image input: data:image/jpg;base64, base64_encode( $user["Profile"]["image"] )
echo $this->Form->input("Profile.gpa",array("default"=>$user["Profile"]["gpa"],"type"=>"number","step"=>"0.001","min"=>0,"max"=>4));
echo $this->Form->end("Save");
?>

<?php echo $this->Html->script("browser-image-compression",array("inline"=>true,"type"=>"module")); ?>
<?php echo $this->Html->script("image-input",array("inline"=>false,"defer"=>true)); ?>
<?php echo $this->Html->script("options",array("inline"=>false)); ?>


<script>
//url
let url={
    getLimitedSchool: "<?php echo $this->Html->url( array("action"=>"LimitedSchools"))?>",
    getLimitedDepartment: "<?php echo $this->Html->url( array("action"=>"LimitedDepartments"))?>"
};

//class names attached to each input areas //these classes must be attached to least elements
let courseInputAreas=new Array();
courseInputAreas.faculty = document.getElementsByClassName("FacultyInputArea");
courseInputAreas.school = document.getElementsByClassName("SchoolInputArea");
courseInputAreas.department = document.getElementsByClassName("DepartmentInputArea");

//get all json data from database (mid: php)
let rawCourseJson=new Array();
rawCourseJson.faculty=<?php echo json_encode($faculties) ?>;
//rawCourseJson.school=<?php //echo json_encode($schools) ?>;
//rawCourseJson.department=<?php //echo json_encode($departments) ?>;

//user data
let user = <?php $user["Profile"]["image"]=null; echo json_encode($user); ?>;


//function
SetAndManageCourseOptions(url, courseInputAreas, rawCourseJson, user);




</script>