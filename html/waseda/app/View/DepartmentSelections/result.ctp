<?php //debug($userSelections); ?>
<?php //debug($availableDepartmentSelections); ?>

<?php echo !empty($login_id)?"ログインユーザid: ".$login_id:"未ログイン";?>

<div>
<button id="showGPA_now_tot" type="button" >
    <span>GPA(学系別)</span>
</button>
<button id="showGPA_now_1" type="button" >
    <span>GPA(学系1：第1志望)</span>
</button>
<button id="showGPA_now_2" type="button" >
    <span>GPA(学系2：第1志望)</span>
</button>
<button id="showGPA_now_3" type="button" >
    <span>GPA(学系3：第1志望)</span>
</button>
</div>

<div>
<button id="showDepartmentSelections_now_tot" type="button" >
    <span>学科選択分布(学系別:第1志望)</span>
</button>
<button id="showDepartmentSelections_now_1" type="button" >
    <span>学科選択分布(学系1)</span>
</button>
<button id="showDepartmentSelections_now_2" type="button" >
    <span>学科選択分布(学系2)</span>
</button>
<button id="showDepartmentSelections_now_3" type="button" >
    <span>学科選択分布(学系3)</span>
</button>
</div>

<canvas id="chart"></canvas>


<!--
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
<?php //foreach($userSelections as $userSelection): ?>
    <tr>
        <td> <?php //echo $userSelection["NowDepartment"]["department"];?> </td>
        <td> <?php //echo $userSelection["NextDepartment"]["department"];?> </td>
        <td> <?php //echo $userSelection["UserDepartmentSelection"]["rank"];?> </td>
        <td> <?php //echo $userSelection["Gpa"]["gpa"];?> </td>
    </tr>
<?php //endforeach; ?>
    
</tbody>

</table>
-->


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

    $availableData;
    for($i=0;$i<count($availableDepartmentSelections);$i++){
        $availableData[$i]=[
            "now_department"=>$availableDepartmentSelections[$i]["NowDepartment"]["department"],
            "next_department"=>$availableDepartmentSelections[$i]["NextDepartment"]["department"],
            "max_num"=>$availableDepartmentSelections[$i]["AvailableDepartmentSelection"]["max_num"],
        ];
    }
?>









<script>
//data = [{now_department: "学系1", next_department: "数学科", rank: "1", gpa: "3.235"},{}]
const data=<?php echo json_encode($data); ?>; ////console.log(data);
const availableData=<?php echo json_encode($availableData); ?>; console.log(availableData);
const ctx=document.getElementById("chart").getContext("2d");

var myChart;


const chartBaseColors=["rgba(255,0,0,1)","rgba(0,255,0,1)","rgba(0,0,255,1)","rgba(125,0,0,1)","rgba(0,125,0,1)","rgba(0,0,125,1)","rgba(125,125,0,1)","rgba(0,125,125,1)","rgba(125,0,125,1)","rgba(0,0,0,1)",];

//countAndDrawBars(ctx,data,{"type":"in", "border":["学系1","学系2","学系3"], "field":"now_department", "categories":{"rank":[1,2,3]}, },chartBaseColors,{x:"現在の学部",y:"度数",categories:["第一志望","第二志望","第三志望"]});

//console.log( extractData(availableData,{"conditions":{"now_department":"学系1"},"targets":["next_department"]})["next_department"] );


document.getElementById("showGPA_now_tot").addEventListener("click",function(){
    var categories=extractData(availableData,{"conditions":{},"targets":["now_department"]})["now_department"];
    categories.push("*");
    const option={
        "type":"range", 
        "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], 
        "field":"gpa",
        "conditions": {"rank":1}, 
        "categories":{
            "now_department": categories,
        } 
    };
    const names={
        title: "GPA分布(学系別)",
        x:"GPA",
        y:"度数(人)",
        categories:["学系1","学系2","学系3","全て"] 
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showGPA_now_1").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系1"},"targets":["next_department"]})["next_department"];
    const option={
        "type":"range", 
        "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], 
        "field":"gpa",
        "conditions": {"rank":1,"now_department":"学系1"}, 
        "categories":{
            "next_department":categories,
        } 
    };
    const names={
        title: "GPA分布(学系1：第1志望)",
        x:"GPA",
        y:"度数(人)",
        categories: categories
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showGPA_now_2").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系2"},"targets":["next_department"]})["next_department"];
    const option={
        "type":"range", 
        "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], 
        "field":"gpa",
        "conditions": {"rank":1,"now_department":"学系2"}, 
        "categories":{
            "next_department":categories
        } 
    };
    const names={
        title: "GPA分布(学系2：第1志望)",
        x:"GPA",
        y:"度数(人)",
        categories:categories 
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showGPA_now_3").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系3"},"targets":["next_department"]})["next_department"];
    const option={
        "type":"range", 
        "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], 
        "field":"gpa",
        "conditions": {"rank":1,"now_department":"学系3"}, 
        "categories":{
            "next_department": categories
        } 
    };
    const names={
        title: "GPA分布(学系3：第1志望)",
        x:"GPA",
        y:"度数(人)",
        categories: categories
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showDepartmentSelections_now_tot").addEventListener("click",function(){
    const borders=extractData(availableData,{"conditions":{},"targets":["now_department"]})["now_department"];
    const categories=extractData(availableData,{"conditions":{},"targets":["next_department"]})["next_department"];
    const option={
        "type":"in", 
        "border":borders, 
        "field":"now_department",
        "conditions": {"rank":1}, 
        "categories":{
            "next_department":categories
        } 
    };
    const names={
        title: "学科選択分布(学系別)",
        x:"学科志望先",
        y:"度数(人)",
        categories:categories
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showDepartmentSelections_now_1").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系1"},"targets":["next_department"]})["next_department"];
    var border_o=new Array();var border_n=new Array();
    for(let i=1;i<=categories.length;i++){ border_o.push(i); border_n.push("第"+i+"志望"); }

    const option={
        "type":"in", 
        "border":border_o, 
        "field":"rank",
        "conditions": {"now_department":"学系1"}, 
        "categories":{
            "next_department":categories
        } 
    };
    const names={
        title: "学科選択分布(学系1)",
        x:"志望順位",
        y:"度数(人)",
        border: border_n,
        categories:categories
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showDepartmentSelections_now_2").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系2"},"targets":["next_department"]})["next_department"];
    var border_o=new Array();var border_n=new Array();
    for(let i=1;i<=categories.length;i++){ border_o.push(i); border_n.push("第"+i+"志望"); }

    const option={
        "type":"in", 
        "border":border_o, 
        "field":"rank",
        "conditions": {"now_department":"学系2"}, 
        "categories":{
            "next_department":categories
        } 
    };
    const names={
        title: "学科選択分布(学系2)",
        x:"志望順位",
        y:"度数(人)",
        border: border_n,
        categories: categories 
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});

document.getElementById("showDepartmentSelections_now_3").addEventListener("click",function(){
    const categories=extractData(availableData,{"conditions":{"now_department":"学系3"},"targets":["next_department"]})["next_department"];
    var border_o=new Array();var border_n=new Array();
    for(let i=1;i<=categories.length;i++){ border_o.push(i); border_n.push("第"+i+"志望"); }

    const option={
        "type":"in", 
        "border":border_o, 
        "field":"rank",
        "conditions": {"now_department":"学系3"}, 
        "categories":{
            "next_department":categories
        } 
    };
    const names={
        title: "学科選択分布(学系3)",
        x:"志望順位",
        y:"度数(人)",
        border: border_n,
        categories:categories 
    };
    if(myChart) myChart.destroy();
    myChart = countAndDrawBars(ctx,data, option,chartBaseColors, names );
});






</script>