<?php 
    //blobはデータ量多いからdebugで表示されない？debugで表示される様にblobデータをnullにしている
    //debug($user); 
?>

<h2>User: <?php echo isset($user["User"]["username"])?$user["User"]["username"]:"-"; ?> </h2>
<img src="<?php echo isset($user["Profile"]["image"])?$user["Profile"]["image"]:"-";?>" class="profile-image-middle"/>
<p>id: <?php echo $user["User"]["id"];  ?> </p>
<p>ユーザネーム: <?php echo isset($user["User"]["username"])?$user["User"]["username"]:"-"; ?> </p>
<p>入学年度:  <?php echo isset($user["Profile"]["enter_year"]) ? $user["Profile"]["enter_year"] : "-"; ?> </p>
<p>学術院: <?php echo isset($user["Profile"]["Faculty"]["faculty"]) ? $user["Profile"]["Faculty"]["faculty"] : "-"; ?> </p>
<p>学部: <?php echo isset($user["Profile"]["School"]["school"]) ? $user["Profile"]["School"]["school"] : "-"; ?> </p>
<p>学科: <?php echo isset($user["Profile"]["Department"]["department"]) ? $user["Profile"]["Department"]["department"] : "-"; ?> </p>
<!-- <p>GPA: <?php //echo isset($user["Gpa"]["gpa"]) ? $user["Gpa"]["gpa"] : "-"; ?> </p> -->
<p>コメント: </br><?php echo isset($user["Profile"]["comment"]) ? nl2br($user["Profile"]["comment"]) : "-"; ?> </p>

<button > <?php echo !empty($isAuthor)?$this->Html->link("edit",["action"=>"edit",$user["User"]["id"]]):null;?> </button>





<h3><?php //echo $this->Html->Link("学科選択調査に参加する",["controller"=>"DepartmentSelections","action"=>"index"])  ?></h3>