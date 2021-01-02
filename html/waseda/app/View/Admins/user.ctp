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
        //blobはデータ量多いからdebugで表示されない？debugで表示される様にblobデータをnullにしている
        /*
        $num=count($users);
        for($i=0;$i<$num;$i++){ 
            $users[$i]["Grade"]["image"]=null; 
            echo($users[$i]["Grade"]["image"]); 
        } 
        debug($users[0]); 
        */
    ?>


    <table>
        <thead>
            <th>id</th>
            <th>image</th>
            <th>name</th>
            <th>password</th>
            <th>created</th>
            <th>modified</th>
            <th></th>
        </thead>   
        <?php foreach ($users as $user) : ?>
            <tr>
                <td> <?php echo($user["User"]["id"]) ?> </td>
                <td> <?php echo('<img src="data:image/jpg;base64,'.base64_encode($user["Grade"]["image"]).'" height="30px"/>'); ?> </td>
                <td> <?php echo($user["User"]["name"]) ?> </td>
                <td> <?php echo($user["User"]["password"]) ?> </td>
                <td> <?php echo($user["User"]["created"]) ?> </td>
                <td> <?php echo($user["User"]["modified"]) ?> </td>   
                <td> <?php echo($this->Html->link("edit",["controller"=>"Admins","action"=>"userEdit",$user["User"]["id"]])) ?> </td>
            </tr>         
        <?php endforeach ?>
    </table>
    <h2>Grade</h2>
    <table>
        <thead>
            <th>user_id</th>
            <th>enter_year</th>
            <th>department_id</th>
            <th>department</th>
            <th>course_id</th>
            <th>course</th>
            <th>gpa</th>
            <th>comment</th>
            <th>modified</th>
        </thead>   
        <?php foreach ($users as $user) : ?>
            <?php 
                if(isset($user["Grade"]["user_id"])){
                    echo "<td>".$user["Grade"]["user_id"]."</td>";               
                    echo "<td>".$user["Grade"]["enter_year"]."</td>";
                    echo "<td>".$user["Grade"]["Department"]["department"]."</td>";
                    echo "<td>".$user["Grade"]["course_id"]."</td>";
                    echo "<td>".$user["Grade"]["Course"]["course"]."</td>";
                    echo "<td>".$user["Grade"]["gpa"]."</td>";
                    echo "<td>".$user["Grade"]["comment"]."</td>";
                    echo "<td>".$user["Grade"]["modified"]."</td>";
                }else{
                    echo "<td></td>";               
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                }
            ?>
            <tr>
                          
            </tr>  
        <?php endforeach ?>
    </table>

</body>
</html>




