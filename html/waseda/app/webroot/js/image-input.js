const maxSizeMB=0.05; //blob is 6kb
const maxWidthOrHeight=256; //image's max width(height)

document.addEventListener("DOMContentLoaded", function() {

    var imageInputs=document.getElementsByClassName("imageInput");
    var imageOutputs=document.getElementsByClassName("imageOutput");
    var imageDataInputs=document.getElementsByClassName("imageDataInput");

    for(let i=0;i<imageInputs.length;i++){ //if use "var", i is not 0, i goes up to 1
        imageInputs[i].addEventListener("change",function(e){
            //console.log(e.target.files[0].size+" : "+maxSizeMB*1000000);
            if(e.target.files[0].size>maxSizeMB*1000000){
                alert("This image is bigger than "+maxSizeMB+"MB. \nThis image is compressed.");
                handleImageCompress(e,i);
            }else{
                renderImage(e.target.files[0],i);
            }
        });
    };

    


    //compress image
    //cannot change input image file due to security, 
    //so there are several ways to save compressed image: 
    //  1)compress php before save, 
    //  2)upload by xmlhttprequest (or ajax)  
    //  3)upload by text as dataURL https://stackoverflow.com/questions/14672746/how-to-compress-an-image-via-javascript-in-the-browser/14672943#14672943
    //I decided the way 1), but compress image using js to show compressed image.
    async function handleImageCompress(e ,i){
        const imageFile = e.target.files[0];    
        console.log('originalFile instanceof Blob', imageFile instanceof Blob); // true
        console.log(`originalFile size ${imageFile.size / 1024 / 1024} MB`);

        const options = {
            maxSizeMB: maxSizeMB,
            maxWidthOrHeight: maxWidthOrHeight,
            useWebWorker: true
        };

        try{
            const compressedFile = await imageCompression(imageFile, options);
            console.log('compressedFile instanceof Blob', compressedFile instanceof Blob); // true
            console.log(`compressedFile size ${compressedFile.size / 1024 / 1024} MB`); // smaller than maxSizeMB
            
            await renderImage(compressedFile,i); // write your own logic
        }catch(error){
            console.log(error);
        };
    }



    //render image
    function renderImage(input, i){
        var reader = new FileReader();
        reader.onload=function(e){
            imageOutputs[i].src=e.target.result;
            console.log(imageOutputs[i].width);
            imageOutputs[i].width>imageOutputs[i].height?imageOutputs[i].width=maxWidthOrHeight:imageOutputs[i].height=maxWidthOrHeight;
            //console.log(e.target.result);

            //setImageDataURL
            setImageDataURL(e.target.result,i);
        }
        reader.readAsDataURL(input);
    }

    //setImageDataURL of input image file =>sendToServer
    //base64url is about 33% larger than raw. So another way may better
    //however, base64url is not effected by serialization (htmlspecialchars of php).
    function setImageDataURL(imageDataUrl,i){
        console.log(imageDataUrl);
        imageDataInputs[i].value=imageDataUrl; 
        
    }

});
