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
        echo $users[2]["Profile"]["image"];
        $num=count($users);
        for($i=0;$i<$num;$i++){ 
            $users[$i]["Profile"]["image"]=null; 
            echo($users[$i]["Profile"]["image"]); 
        } 
        debug($users[1]); 
        */
    ?>

    <h2>Users</h2>
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
                <td> <?php echo $user["User"]["id"];  ?> </td>
                <td> <?php echo '<img src="'.$user["Profile"]["image"].'" height="30px"/>'; ?> </td>
                <td> <?php echo $user["User"]["name"]; ?> </td>
                <td> <?php echo $user["User"]["password"]; ?> </td>
                <td> <?php echo $user["User"]["created"]; ?> </td>
                <td> <?php echo $user["User"]["modified"]; ?> </td>   
                <td> <?php echo $this->Html->link("edit",["controller"=>"Admins","action"=>"userEdit",$user["User"]["id"]]); ?> </td>
            </tr>         
        <?php endforeach ?>
    </table>
    
    <h2>Profile</h2>
    <table>
        <thead>
            <th>user_id</th>
            <th>enter_year</th>
            <th>School_id</th>
            <th>School</th>
            <th>Department_id</th>
            <th>Department</th>
            <th>gpa</th>
            <th>comment</th>
            <th>modified</th>
        </thead>   
        <?php foreach ($users as $user) : ?>
            <?php 
                if(!empty($user["Profile"]["user_id"])){
                    echo "<td>".$user["Profile"]["user_id"]."</td>";               
                    echo "<td>".$user["Profile"]["enter_year"]."</td>";
                    echo "<td>".$user["Profile"]["school_id"]."</td>";
                    echo "<td>".$user["Profile"]["School"]["school"]."</td>";
                    echo "<td>".$user["Profile"]["department_id"]."</td>";
                    echo "<td>".$user["Profile"]["Department"]["department"]."</td>";
                    echo "<td>".$user["Profile"]["gpa"]."</td>";
                    echo "<td>".$user["Profile"]["comment"]."</td>";
                    echo "<td>".$user["Profile"]["modified"]."</td>";
                }else{
                    echo "<td>".$user["User"]["id"]."</td>";               
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




