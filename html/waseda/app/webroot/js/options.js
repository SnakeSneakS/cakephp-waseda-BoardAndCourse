//crate options by js => realtime input field with options

//$courseSelection["Department"]["department"] 
//e.g. CreateOptions(htmlElement,array([["Department"=["department"=>"","id"=>0]],[["Department"=["department"=>"","id"=>0]]]))
function CreateOptions(htmlElement,array,initialId){  //初期値を付けたい 
    var options="";
    options+="<option disabled selected value>(choose one)</option>"
    for(var key in array){
        options+="<option value="+key;
        if(key==initialId){ options+=" selected" }
        options+=" >"+array[key]+"</option>";
    }
    htmlElement.innerHTML=options;
    //console.log(options);
}

function EncodeJsonForOption(RowArray,modelName,fieldName,idName){
    var arr=new Array();
    //console.log(arr);
    for(var i=0;i<RowArray.length;i++){
        var index=RowArray[i][modelName][idName];
        arr[index]=RowArray[i][modelName][fieldName];
    }
    return arr;
    /*
        result:
        arr{
            ${idName} => [ $fieldName, $ ],
            [idName]=>[fieldName],
            [idName]=>[fieldName],
            ...
        } 
    */
}

//  ajax by html
var request = new XMLHttpRequest();
request.open("get", "/serach?query=hoge&order=desc", true);
request.onload = function (event) {
  if (request.readyState === 4) {
    if (request.status === 200) {
      console.log(request.statusText); // => "OK"
    } else {
      console.log(request.statusText); // => Error Message
    }
  }
};
request.onerror = function (event) {
  console.log(event.type); // => "error"
};
request.send(null);