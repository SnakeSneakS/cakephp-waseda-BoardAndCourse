
<?php
echo $this->Html->link("view",array("action"=>"view",$user["User"]["id"]));
?>

<h2>User: edit</h2>

<?php //debug($user); ?>

<?php
echo $this->Form->create("User",array(/*"enctype"=>"multipart/form-data"*//*"type"=>"file"*/));

echo $this->Html->tag("h3","Basic");
echo $this->Form->hidden("User.id",array("default"=>$user["User"]["id"]));
echo $this->Form->input("User.username",array("default"=>$user["User"]["username"],"label"=>"ユーザネーム"));
echo $this->Form->input("User.password",array("default"=>$user["User"]["password"],"label"=>"パスワード"));

echo $this->Html->tag("h3","Additional"/*,array("class"=>"sub-title")*/ );
echo $this->Form->hidden("Profile.user_id",array("default"=>$user["User"]["id"]));
echo $this->Form->label("入学年度","入学年度");
echo $this->Form->year("Profile.enter_year", date("Y")-10, date("Y"), array("default"=>$user["Profile"]["enter_year"],"placeholder"=>(date("Y")-10)." ~ ".date("Y") ));
//echo $this->Form->input("Profile.enter_year",array("default"=>$user["Profile"]["enter_year"],"type"=>"number","label"=>"入学年","step"=>"1","min"=>date("Y")-10,"max"=>date("Y"),"placeholder"=>(date("Y")-10)." ~ ".date("Y") ));
echo $this->Form->input("Profile.faculty_id",array("placeholder"=>"学術院","options"=>[],"label"=>"学術院","class"=>"FacultyInputArea" ));
echo $this->Form->input("Profile.school_id",array("placeholder"=>"学部","options"=>[],"label"=>"学部","class"=>"SchoolInputArea"));
echo $this->Form->input("Profile.department_id",array("placeholder"=>"学科","options"=>[],"label"=>"学科","class"=>"DepartmentInputArea" ));
echo $this->Form->input("Profile.comment",array("default"=>nl2br($user["Profile"]["comment"]),"label"=>"一言コメント" ));
//echo $this->Form->input("Profile.image",("type"=>"file",'label' => "profile-image", "accept"=>"image/*" ,"class"=>"imageInput")); //when send file. I decided to send imageDataUrl. type: "file" is needed when form->create
echo $this->Form->input("null",array("type"=>"file",'label' => "プロフィール画像", "accept"=>"image/*" ,"class"=>"imageInput"));
echo $this->Form->hidden("Profile.image",array("default"=>$user["Profile"]["image"],'label' => "profile-image-data", 'type' => 'text', "accept"=>"image/*" ,"class"=>"imageDataInput"));
echo('<img class="imageOutput" src="'.$user["Profile"]["image"].'" height="300px"/>'); //when use image input: data:image/jpg;base64, base64_encode( $user["Profile"]["image"] )
//echo $this->Form->input("Gpa.gpa",array("default"=>$user["Gpa"]["gpa"],"type"=>"number","label"=>"平均GPA","step"=>"0.001","min"=>0,"max"=>4));

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