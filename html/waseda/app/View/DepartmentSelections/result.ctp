<?php //debug($userSelections); ?>


<canvas id="chart"></canvas>



<table>
<thead>
    <tr>
        <td>現在学部</td>
        <td>志望学部</td>
        <td>志望順位</td>
        <td>gpa</td>
    </tr>
</thead>
<tbody>
<?php foreach($userSelections as $userSelection): ?>
    <tr>
        <td> <?php echo $userSelection["NowDepartment"]["department"];?> </td>
        <td> <?php echo $userSelection["NextDepartment"]["department"];?> </td>
        <td> <?php echo $userSelection["UserDepartmentSelection"]["rank"];?> </td>
        <td> <?php echo $userSelection["Gpa"]["gpa"];?> </td>
    </tr>
<?php endforeach; ?>
    
</tbody>

</table>


<?php echo $this->Html->script("Chart.min",array("inline"=>false)); ?>
<?php echo $this->Html->script("forChartJs",array("inline"=>false)); ?>

<?php
    //ready data for js
    $data;
    for($i=0;$i<count($userSelections);$i++){
        $data[$i]=[
            //"id"=>$userSelections[$i]["UserDepartmentSelection"]["id"],
            "now_department"=>$userSelections[$i]["NowDepartment"]["department"],
            "next_department"=>$userSelections[$i]["NextDepartment"]["department"],
            "rank"=>$userSelections[$i]["UserDepartmentSelection"]["rank"],
            "gpa"=>$userSelections[$i]["Gpa"]["gpa"],
        ];
    }
?>









<script>
//data = [{now_department: "学系1", next_department: "数学科", rank: "1", gpa: "3.235"},{}]
const data=<?php echo json_encode($data); ?>;
const ctx=document.getElementById("chart");


const chartBaseColors=["rgba(255,0,0,1)","rgba(0,255,0,1)","rgba(0,0,255,1)","rgba(125,125,0,1)","rgba(125,0,125,1)","rgba(0,125,125,1)","rgba(125,0,0,1)","rgba(0,125,0,1)","rgba(0,0,125,1)"];

//countAndDrawBars(ctx,data,{"type":"in", "border":["学系1","学系2","学系3"], "field":"now_department", "categories":{"rank":[1,2,3]}, },chartBaseColors,{x:"現在の学部",y:"度数",categories:["第一志望","第二志望","第三志望"]});
countAndDrawBars(ctx,data,{"type":"range", "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], "field":"gpa","conditions": {"rank":1}, "categories":{"now_department":["学系1","学系2","学系3","*"]} },chartBaseColors,{x:"gpa分布（第一志望）",y:"度数",categories:["学系1","学系2","学系3","全て"] } );






</script>