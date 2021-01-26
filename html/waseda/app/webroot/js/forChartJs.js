/*
//data = [{now_department: "学系1", next_department: "数学科", rank: "1", gpa: "3.235"},{}]
const data=[];
const ctx=document.getElementById("chart");


const limitResult={
    now_department: limitData(data,{ "conditions" : { "now_department":"学系1" } } ),
}
const countResult={
    gpa: countData(data,{"type":"range", "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], "field":"gpa", }),
    department: countData(data,{ "type": "in", "border":["学系1","学系2","学系3",], "field":"now_department"}),
};
console.log(limitResult["now_department"]);
console.log(countResult["gpa"]);
console.log(countResult["department"]);


//drawBarOne(ctx,countResult.gpa);


const chartBaseColors=["rgba(255,0,0,1)","rgba(0,255,0,1)","rgba(0,0,255,1)","rgba(125,125,0,1)","rgba(125,0,125,1)","rgba(0,125,125,1)","rgba(125,0,0,1)","rgba(0,125,0,1)","rgba(0,0,125,1)"];
//countAndDrawBars(ctx,data,{"type":"in", "border":["学系1","学系2","学系3"], "field":"now_department", "categories":{"rank":[1,2,3]}, },chartBaseColors,{x:"現在の学部",y:"度数",categories:["第一志望","第二志望","第三志望"]});
countAndDrawBars(ctx,data,{"type":"range", "border":[0.2,0.4,0.6,0.8,1.0,1.2,1.4,1.6,1.8,2.0,2.2,2.4,2.6,2.8,3.0,3.2,3.4,3.6,3.8,4.0], "field":"gpa","conditions": {"rank":1}, "categories":{"now_department":["学系1","学系2","学系3","*"]} },chartBaseColors,{x:"gpa分布（第一志望）",y:"度数",categories:["学系1","学系2","学系3","全て"] } );

*/


function drawBarOne(ctx,countResult,conditions){
    var label="";
    for(let key in countResult["conditions"]){
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

// data: {"field1": "value1", "field2": "value2"}, options: { "type": "in", "border":["学系1","学系2","学系3"], "field":"gpa", "conditions":{"fieldType": ["fieldName1","fieldName2"], names:{title:"title", x:"xLabel", y: "yLabel", conditions:["category1","category2"]} }}
function countAndDrawBars(ctx,data,options={type:"",border:[],field:"",conditions:{}},colors, names={title:"title", x:"x-label", y: "y-label", conditions:[], border:[] }){
    var datasetsArray=new Array();
    
    for(let key in options["categories"]){ 
        const len=options["categories"][key].length;
        console.log(len);
        for(let i=0;i<len;i++){

            var option={
                "type": options["type"],
                "border":options["border"], 
                "field":options["field"], 
                "conditions":options["conditions"]?options["conditions"]:{}
            };
            option["conditions"][key]=options["categories"][key][i];
            
            datasetsArray[i]={
                label: names["categories"]?names["categories"][i]:key+":"+option["categories"][key], 
                data: countData(data,option).v,
                backgroundColor: colors[i],
            };
            
        }
    }
    
    console.log(datasetsArray);

    var option={
        "type": options["type"],
        "border":options["border"], 
        "field":options["field"], 
        "conditions":{}
    };

    var chart=new Chart(ctx,{
        type: "bar",
        data: {
            labels: countData(data,option).k,
            datasets: datasetsArray ,
        },
        options: {
            title: {
                display: true,
                text: options["field"],
            },
            scales: {
                xAxes:[{
                    scaleLabel: {
                        display: true,
                        labelString: names["x"]?names["x"]:"x-label",
                    }
                }],
                yAxes:[{
                    scaleLabel: {
                        display: true,
                        labelString: names["y"]?names["y"]:"y-label",
                    }
                }],
            }
        },
    });
}



//gpa分布
//option={"conditions":{"now_department":"","next_department":"",}}
function limitData(data,option={}){

    if( !option["conditions"] || option["conditions"]=={} ) return data; 

    var newData=new Array();
    for(let keyD in data){   
        var ok=true;
        for(let keyField in option["conditions"]){
            if(data[keyD][keyField]!=option["conditions"][keyField]){
                if(option["conditions"][keyField]=="*"){ continue; } //allow all if *
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
    for(let i=0;i<countResult.k.length;i++) countResult.k[i]="その他"; 
    for(let i=0;i<countResult.v.length;i++) countResult.v[i]=0; 

    //key for countResult
    if(option["type"]=="range"){
        for(let i=0;i<option["border"].length+1;i++){
            if(i==0){ countResult.k[i]=option["border"][i]+"~"; 
            }else if(i==option["border"].length){ countResult.k[i]="~"+option["border"][i-1]; 
            }else{ countResult.k[i]=option["border"][i-1]+"~"+option["border"][i] }; 
        }
    }
    else if(option["type"]=="in"){
        for(let i=0;i<option["border"].length;i++){
            countResult.k[i]=option["border"][i]; 
        }
    }

    //value for countResult
    for(let keyD in data){
        //console.log(data[keyD][option["field"]]);
        
        if(option["type"]=="range"){ //if categorize by range  - e.g. {1,2,3,4,5}
            
            var category=option["border"].length;
            for(let i=0;i<option["border"].length;i++){
                if(data[keyD][option["field"]]<option["border"][i]){
                    category=i;
                    break;
                }
            }  
            countResult.v[category]++; 

        }
        else if(option["type"]=="in"){ //if categorize by in - e.g. {"departmentA","departmentB","departmentC"}
            var category=option["border"].length;
            for(let i=0;i<option["border"].length;i++){
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