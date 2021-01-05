document.addEventListener("DOMContentLoaded", function() {

    var imageInputs=document.getElementsByClassName("imageInput");
    var imageOutputs=document.getElementsByClassName("imageOutput");

    for(let i=0;i<imageInputs.length;i++){ //if use "var", i is not 0, i goes up to 1
        imageInputs[i].addEventListener("change",function(e){
            var reader=new FileReader();
            reader.onload=function(e){ 
                console.log(i);
                imageOutputs[i].src=e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        });
        
    };

});


