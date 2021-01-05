//crate options by js => realtime input field with options

//$courseSelection["Department"]["department"] 
//e.g. CreateOptions(htmlElement,array([["Department"=["department"=>"","id"=>0]],[["Department"=["department"=>"","id"=>0]]]))
function CreateOptions(htmlElement,array,initialId){  //初期値を付けたい 
    var options="";
    options+="<option selected value=>(not selected)</option>" //with disabked, you can make this unselectable
    for(var key in array){
        options+="<option value="+key;
        if(key==initialId){ options+=" selected" }
        options+=" >"+array[key]+"</option>";
    }
    htmlElement.innerHTML=options;
    //console.log(options);
}

function EncodeJsonForOption(RowArray={},modelName,fieldName,idName,checkId=null){
    var arr=new Array();
    
    //console.log(arr);
    for(var i=0;i<RowArray.length;i++){
        var index=RowArray[i][modelName][idName];

        if(checkId!=null){ //id check: condition
            if(!checkId(index)){ //e.g. function checkId(id){ available={0,1,2,3,4}; return available.indexOf(id)!=-1; } //true if id is included in available
                continue;
            }
        }
 
        arr[index]=RowArray[i][modelName][fieldName];
    }
    return arr;
}

//ajax by raw js  //referred to https://qiita.com/okame_qiita/items/e1b370c4ecac50cb48da
//fetch might be better
//jquery might better
//USE JQUERY
/*
function ajaxGet(url,conf=[user="user",password="password"]){
    // リクエストオブジェクト作成（IEクロスブラウザ対策有り）
    try {
        request = new XMLHttpRequest();
    }catch(trymicrosoft) {
        try{
            request = new ActiveXObject('Msxm12.XMLHTTP');
        }catch(othermicrosoft) {
            try{
                request = new ActiveXObject('Microsoft.XMLHTTP');
            }catch (failed) {
                request = null;
                console.log('エラー! requestオブジェクトの作成に失敗しました。');
            }
        }
    }
    request.responseType="json";
    request.timeout = 5000;
    request.open('GET', url, true, conf["user"]?conf["user"]:"user", conf["password"]?conf["password"]:"password");
    request.send(null);
    request.onreadystatechange = updatePage;
  
    // レスポンス処理
    function updatePage() {
        if (request.readyState === 4 && request.status === 200) {
            console.log(request.response)
            console.log(JSON.parse(request.response) );
        }else{
            console.log("ERROR: "+request.status);
        }
    }
}
*/


//require jquery  //I wanted to write this without jquery, but couldn't through the "$this->request->is(ajax)" in AdminsController.php
function ajaxGetJson(url="",data){
    return $.ajax({
        url: url,
        type: "get",
        timeout: 30000,
        cashe: false,
        //async: false, //wait until get data //probably no problem in this app
        dataType: "json",
        data: data, //user, password, faculty_id
        }).done(function(response){
            if(response.status==="err"){
                console.log(response.msg);
            }else{
                console.log(response);
                //return response;
            }
        }).fail(function(xhr){
            console.log("Failed");
            console.log(xhr.responseText);
        }).always(function(xhr,msg){
            
        });
}

//initial first, and add event "onchange"
function SetAndManageCourseOptions(url, courseInputAreas, rawCourseJson, user){

    //faculties
    if(courseInputAreas.faculty){
        if(rawCourseJson.faculty){
            faculties=EncodeJsonForOption(rawCourseJson.faculty,"Faculty","faculty","id");
            for(let i=0;i<courseInputAreas.faculty.length;i++) CreateOptions(courseInputAreas.faculty[i],faculties,user["Profile"]["faculty_id"]?user["Profile"]["faculty_id"]:-1);
        } 
    }

    //schools
    if(courseInputAreas.school){
        if(rawCourseJson.school){//if you get json data of all schools
            schools=EncodeJsonForOption(rawCourseJson.school,"School","school","id");
            for(let i=0;i<courseInputAreas.school.length;i++) CreateOptions(courseInputAreas.school[i],schools,user["Profile"]["school_id"]?user["Profile"]["school_id"]:-1);
        }else{//if you get json data of limeted schools available from certain faculty
            ajaxGetJson(url.getLimitedSchool,{faculty_id:user["Profile"]["faculty_id"]?user["Profile"]["faculty_id"]:-1})
            .done(function(response){
                let schools=EncodeJsonForOption(response,"School","school","id");
                for(let i=0;i<courseInputAreas.school.length;i++) CreateOptions(courseInputAreas.school[i],schools,user["Profile"]["school_id"]?user["Profile"]["school_id"]:-1);
            });
        }
    }

    //departments
    if(courseInputAreas.department){
        if(rawCourseJson.department){//if you get json data of all departments
            departments=EncodeJsonForOption(rawCourseJson.department,"Department","department","id");
            for(let i=0;i<courseInputAreas.department.length;i++) CreateOptions(courseInputAreas.department[i],departments,user["Profile"]["department_id"]?user["Profile"]["department_id"]:-1);
        }else{//if you get json data of limeted departmentss available from certain school
            ajaxGetJson(url.getLimitedDepartment,{school_id:user["Profile"]["school_id"]?user["Profile"]["school_id"]:-1})
            .done(function(response){
                departments=EncodeJsonForOption(response,"Department","department","id");
                for(let i=0;i<courseInputAreas.department.length;i++) CreateOptions(courseInputAreas.department[i],departments,user["Profile"]["department_id"]?user["Profile"]["department_id"]:-1);
            });
        }
    }
    


    //when faculty changed
    if(courseInputAreas.faculty){
        for(let i=0;i<courseInputAreas.faculty.length;i++){
            courseInputAreas.faculty[i].addEventListener("change",function(){
                ajaxGetJson(url.getLimitedSchool,{faculty_id:courseInputAreas.faculty[i].value?courseInputAreas.faculty[i].value:-1})
                    .done(function(response){
                    let schools=EncodeJsonForOption(response,"School","school","id");
                    CreateOptions(courseInputAreas.school[i],schools,-1);
                    });
                    CreateOptions(courseInputAreas.department[i],[],-1);
            });
        };
    }
    

    //when school changed
    if(courseInputAreas.school){
        for(let i=0;i<courseInputAreas.school.length;i++){
            courseInputAreas.school[i].addEventListener("change",function(){
                let departments=ajaxGetJson(url.getLimitedDepartment,{school_id:courseInputAreas.school[i].value?courseInputAreas.school[i].value:-1})
                    .done(function(response){
                        departments=EncodeJsonForOption(response,"Department","department","id");
                        CreateOptions(courseInputAreas.department[i],departments,-1);
                    });
            });
        }
    }
    
}