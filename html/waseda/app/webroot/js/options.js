//crate options by js => realtime input field with options

//$courseSelection["Department"]["department"] 
//e.g. CreateOptions(htmlElement,array([["Department"=["department"=>"","id"=>0]],[["Department"=["department"=>"","id"=>0]]]))
function CreateOptions(htmlElement,array){  //初期値を付けたい //条件を付けれるようにしたい。丸々＝丸々、みたいに
    //console.log(array);
    var options="";
    options+="<option disabled selected value>(choose one)</option>"
    for(var i=0;i<array.length;i++){
        options+="<option value="+array[i][modelName][idName];
        if(array[i][modelName][idName]==initialId){ options+=" selected" }
        options+=" >"+array[i][modelName][fieldName]+"</option>";
    }
    htmlElement.innerHTML=options;
    console.log(options);
}

function EncodeJsonForOpinion(RowArray,modelName,fieldName,idName,initialId=-1){
    var arr;
    arr["selected"]= initialId;
    for(var i=0;i<RowArray.length;i++){
        var index=RowArray[i][modelName][idName];
        arr[index]=RowArray[i][modelName][fieldName];
    }
    return arr;
    /*
        result:
        arr{
            "selected"=>initialId,
            [idName]=>[fieldName],
            [idName]=>[fieldName],
            [idName]=>[fieldName],
            ...
        } 

    */
}