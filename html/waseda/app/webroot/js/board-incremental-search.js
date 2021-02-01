window.onload=function(){

    var boards_area=document.getElementsByClassName("boards_area")[0];
    var search={
        interval: 1000,
        available: true,
        reserve: false,
        title: "",
        //to_board_id: document.getElementsByClassName("to_board_id")[0].value,
        func: function(){
            if(!this.available){
                this.reserve=true;
                return;
            }

            this.available=false;
            this_c=this;
            setTimeout(function(){
                this_c.available=true;
                if(this_c.reserve){
                    this_c.reserve=false;
                    this_c.func();
                }
            },this.interval);

            $.ajax({
                url: "/waseda/Boards/search",
                data: { title: this.title },
                type: "get",
                dataType: "json",
            }).done(function(data){
                //console.log(data);
                showBoards(data,boards_area);
            }).fail(function(j,t,e){
                console.error(e);
            });
            
        },
    };



    function showBoards(data,ele){
        console.log(data);

        var result="";

        if(data["boards"].length>=data["limit"]){
            result+="<p style='color:red;'>"+data["limit"]+"件以上検出されました。検索条件を厳しくしてください。</p>";
        }

        if(data["boards"].length==0){
            result+="<p style='color:red;'>検索結果: なし</p>";
        }

        data["boards"].forEach(function(d){
            result+="<div class='board'>";
            result+="<div>"
            result+="<span class='board_link'><a href=./view/"+h(d["Board"]["id"])+">"+h(d["Board"]["title"])+"</a> </span>";
            result+="<span class='small'>";
            result+=h(d["Board"]["modified"])+"</span>";
            result+="</div>";
            result+="</div>";
        });

        ele.innerHTML=result;
    }

    function h(str){
        return (str + '').replace(/&/g,'&amp;')
                        .replace(/"/g,'&quot;')
                        .replace(/'/g,'&#039;')
                        .replace(/</g,'&lt;')
                        .replace(/>/g,'&gt;'); 
    }

    //autocomplete disturb view, so turn off
    $(".board_incremental_search").attr("autocomplete","off");

    //add event
    $(".board_incremental_search").on("input",function(){
        search.title=$(this).val();
        //if(search.title){ // ban [search by ""(空文字) -> find all ]
            search.func();
        //}
    });

}