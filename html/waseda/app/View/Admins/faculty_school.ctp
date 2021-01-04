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
    //debug($facultySchools);
    ?>

    <h3>FacultySchool</h3>
    <table>
        <thead>
            <th>id</th>
            <th>faculty</th>
            <th>school</th>
            <th>delete</th>
            <th></th>
        </thead>  
        
        <?php foreach ($facultySchools as $facultySchool) : ?>
            <tr>
                <?php echo $this->Form->create("FacultySchool") ?>
                <?php echo $this->Form->hidden("FacultySchool.id",array("default"=>$facultySchool["FacultySchool"]["id"])); ?>
                <td> <?php echo $this->Html->tag("span",$facultySchool["FacultySchool"]["id"]) ?> </td>
                <td> <?php echo $this->Form->input("FacultySchool.faculty_id",array("label"=>"","class"=>"facultyInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("FacultySchool.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"schoolInputArea")); ?> 
                <td> <?php echo $this->Form->input("FacultySchool.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>
                <td> <?php echo $this->Form->checkbox("FacultySchool.delete",array("value"=>true)) ?> </td>
                <td> <?php echo $this->Form->end("change") ?> </td>
            </tr>         
        <?php endforeach ?>

        <!-
            新規追加つき
        <tr>
            <?php echo $this->Form->create("FacultySchool") ?>
            <?php echo $this->Form->hidden("FacultySchool.id",array("default"=>1+$facultySchools[count($facultySchools)-1]["FacultySchool"]["id"])); ?>
            <td> <?php echo $this->Html->tag("span",1+$facultySchools[count($facultySchools)-1]["FacultySchool"]["id"]) ?> </td>
            <td> <?php echo $this->Form->input("FacultySchool.faculty_id",array("label"=>"","class"=>"facultyInputArea")); ?> </td>  <?php // phpの場合、<td> <?php echo $this->Form->input("FacultySchool.department_id",array("label"=>"","options"=>$departmentKV,"value"=>$departmentKV, "empty"=>"(choose one)","class"=>"schoolInputArea")); ?> 
            <td> <?php echo $this->Form->input("FacultySchool.school_id",array("label"=>"","class"=>"schoolInputArea")); ?> </td>
            <td> <?php echo $this->Form->checkbox("FacultySchool.delete",array("value"=>true,"hidden"=>true)) ?> </td>
            <td> <?php echo $this->Form->end("new") ?> </td>
        </tr>   
        -->
        

    </table>
    
    <?php echo $this->Html->script("options",array("inline"=>false)); ?>
    <script>
        let FacultySchools=<?php echo json_encode($facultySchools) ?>;
        let faculties=<?php echo json_encode($faculties) ?>;
        let schools=<?php echo json_encode($schools) ?>;
        
        faculties=EncodeJsonForOpinion(faculties,"Faculty","faculty","id");
        schools=EncodeJsonForOpinion(schools,"School","school","id");
        

        console.log(faculties);

        //display available schools first //nowCourseInputArea
        let facultyInputAreas=document.getElementsByClassName("facultyInputArea");
        let schoolInputAreas=document.getElementsByClassName("schoolInputArea");
        for(let i=0;i<facultyInputAreas.length;i++){
            CreateOptions(facultyInputAreas[i],faculties,i<FacultySchools.length?FacultySchools[i]["FacultySchool"]["faculty_id"]:-1);
            CreateOptions(schoolInputAreas[i],schools,i<FacultySchools.length?FacultySchools[i]["FacultySchool"]["school_id"]:-1);
        }
        
    </script>

</body>
</html>




