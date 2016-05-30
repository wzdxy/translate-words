window.onload=function(){
            document.getElementById('btn').onclick=searchJqury;
            //document.getElementById("wrap").innerHTML=xhr.responseText
            
        }
        
        
function searchJqury(params) {
    console.log("jq search run");
    var rText=document.getElementById("text").value;
    $.post(
        'search.php',
        {
                'airticle-texts':rText,
        },
        function(data,status){
            document.getElementById('inner').innerHTML=data;
        }
    )
}        

        
function search() {
    console.log("search run");
    alert("run");
            xhr=new XMLHttpRequest();
            xhr.onreadystatechange=function () {
                if(xhr.readyState==4&&xhr.status==200){
                    jsonText=xhr.responseText;
                    //var wrap=JSON.parse(jsonText);
                    document.getElementById('inner').innerHTML=jsonText;
                }
            }
            xhr.open("post", "search.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            var form = document.getElementById("form");
            //xhr.send(serialize(form));
            xhr.send(form);
}        