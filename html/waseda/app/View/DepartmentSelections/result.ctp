<?php //debug($userSelections); ?>


<canvas id="chart"></canvas>



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


<?php echo $this->Html->script("Chart.min",array("inline"=>false)); ?>

<?php
    //ready data for js
    $data;
    for($i=0;$i<count($userSelections);$i++){
        $data[$i]=[
            "id"=>$userSelections[$i]["UserDepartmentSelection"]["id"],
            "now_department"=>$userSelections[$i]["NowDepartment"]["department"],
            "next_department"=>$userSelections[$i]["NextDepartment"]["department"],
            "rank"=>$userSelections[$i]["UserDepartmentSelection"]["rank"],
            "gpa"=>$userSelections[$i]["Gpa"]["gpa"],
        ];
    }
?>









<script>
const data=<?php echo json_encode($data); ?>;
//console.log(data);
const ctx=document.getElementById("chart");

const limitResult={
    now_department: limitData(data,{ "conditions" : { "now_department":"学系1" } } ),
}
const countResult={
    gpa: countData(data,{"type":"range", "border":[1,2,3], "field":"gpa", }),
    department: countData(data,{ "type": "in", "border":["学系1","学系2","学系3"], "field":"now_department"}),
};
console.log(limitResult["now_department"]);
console.log(countResult["gpa"]);
console.log(countResult["department"]);


drawBar(ctx,countResult.gpa);






function drawBar(ctx,countResult){
    var label="";
    for(key in countResult["conditions"]){
        label+=key+": "+countResult["conditions"][key]+", ";
    }

    var chart=new Chart(ctx,{
        type: "bar",
        data: {
            labels: countResult.k ,
            datasets: [
                {
                    label: label,
                    data: countResult["v"],
                    borderColor: "rgba(255,0,0,1)",
                    backgroundColor: "rgba(0,0,0,1)"
                },
            ]
        },
        options: {
            title: {
                display: true,
                text: countResult["field"],
            },
        },
        
    });
}



//gpa分布
//option={"conditions":{"now_department":"","next_department":"",}}
function limitData(data,option={}){

    if( !option["conditions"] || option["conditions"]=={} ) return data; 

    var newData=new Array();
    for(keyD in data){   
        var ok=true;
        for(keyField in option["conditions"]){
            if(data[keyD][keyField]!=option["conditions"][keyField]){
                ok=false;
                break;
            }
        }
        if(ok) newData.push(data[keyD]);
    }
    return newData;
}

//option={ "type": "range" or "in", "border":[0,10,20,30,40,50](when "range") or ["A","B","C"](when "in"), "field": "gpa", "conditions": {"now_department": "a", "next_department": "b"}}
function countData(data,option={"border": {}, "field": "","conditions": {} }){
    
    //error
    if( option["type"]!="range" && option["type"]!="in" ) console.error('Please choose "type", "range" or "in", to countData ');
    if(!option["border"] || option["border"]=={} ) console.error('Please set "border" array to countData ');
    if(!option["field"] || option["field"]=={} ) console.error('Please set "field" to countData ');

    //limitation
    data=limitData(data,option);

    //initialization of countResult
    var len=0;
    len=option["border"].length;
    var countResult={ field: option["field"], conditions: option["conditions"], k: new Array(len+1), v: new Array(len+1) };
    for(i=0;i<countResult.k.length;i++) countResult.k[i]="その他"; 
    for(i=0;i<countResult.v.length;i++) countResult.v[i]=0; 

    //key for countResult
    if(option["type"]=="range") for(i=0;i<option["border"].length;i++) countResult.k[i]=option["border"][i]+"未満"; 
    else if(option["type"]=="in") for(i=0;i<option["border"].length;i++) countResult.k[i]=option["border"][i]; 

    //value for countResult
    for(keyD in data){
        //console.log(data[keyD][option["field"]]);
        
        if(option["type"]=="range"){ //if categorize by range  - e.g. {1,2,3,4,5}
            
            var category=option["border"].length;
            for(i=0;i<option["border"].length;i++){
                if(data[keyD][option["field"]]<option["border"][i]){
                    category=i;
                    break;
                }
            }  
            countResult.v[category]++; 

        }
        else if(option["type"]=="in"){ //if categorize by in - e.g. {"departmentA","departmentB","departmentC"}
            var category=option["border"].length;
            for(i=0;i<option["border"].length;i++){
                    if(data[keyD][option["field"]]==option["border"][i]){
                        category=i;
                        break;
                    }
                }  
            countResult.v[category]++; 
        }
        
    }

    //result
    return countResult;
}

</script>