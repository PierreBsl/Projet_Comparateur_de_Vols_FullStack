function showHint() {
    console.log("Key up");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("txtHint").innerHTML = this.responseText;
            let tab=this.responseText.split(',');
            console.log(tab);
            tab=JSON.parse(tab);
            console.log(tab["ville"].length);
            document.getElementById("ville2").innerHTML = "";
            document.getElementById("ville3").innerHTML = "";
            for(let i=0; i<tab["ville"].length; i++){
                document.getElementById("ville2").innerHTML += '<option value="'+tab["code"][i]+'">'+tab["ville"][i]+'</option>';
                document.getElementById("ville3").innerHTML += '<option value="'+tab["code"][i]+'">'+tab["ville"][i]+'</option>';
            }

        }
    };
    xmlhttp.open("GET", "gethint.php", true);
    xmlhttp.send();
}

window.onload = function() {
    console.log("Debut SQL");
    showHint();

};


function main() {
    console.log("Start");
    //onloadstart(showHint());

}
main();