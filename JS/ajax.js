
function showHint() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            let tab=this.responseText.split(',');
            tab=JSON.parse(tab);
            document.getElementById("ville2").innerHTML = "";
            document.getElementById("ville3").innerHTML = "";
            for(let i=0; i<tab["ville"].length; i++){
                document.getElementById("ville2").innerHTML += '<option value="'+tab["code"][i]+'">'+tab["ville"][i]+'</option>';
                document.getElementById("ville3").innerHTML += '<option value="'+tab["code"][i]+'">'+tab["ville"][i]+'</option>';
            }
            document.getElementById("loading").innerHTML ="";

        }
    };
    xmlhttp.open("GET", "gethint.php", true);
    xmlhttp.send();

}

window.onload = function() {
    showHint();


};


function main() {

}
main();