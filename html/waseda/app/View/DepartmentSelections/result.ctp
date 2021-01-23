<?php debug($userSelections); ?>

<table>
<thead>
    <tr>
        <td>id</td>
        <td>現在学部</td>
        <td>志望学部</td>
        <td>志望順位</td>
        <td>gpa</td>
    </tr>
</thead>
<tbody>
<?php foreach($userSelections as $userSelection): ?>
    <tr>
        <td> <?php echo $userSelection["UserDepartmentSelection"]["id"];?> </td>
        <td> <?php echo $userSelection["NowDepartment"]["department"];?> </td>
        <td> <?php echo $userSelection["NextDepartment"]["department"];?> </td>
        <td> <?php echo $userSelection["UserDepartmentSelection"]["rank"];?> </td>
        <td> <?php echo $userSelection["Gpa"]["gpa"];?> </td>
    </tr>
<?php endforeach; ?>
    
</tbody>

</table>

<script>
<?php
$data=$userSelection;
?>
const data=<?php echo json_encode($userSelections); ?>;
console.log(data);
</script>