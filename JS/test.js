function showHint(id) {
    let value1 = document.getElementById(id)
    str=value1;
    console.log("Key up"+str);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("txtHint").innerHTML = this.responseText;
            let tab=this.responseText.split(',');
            console.log(tab);
            document.getElementById(id).innerHTML = "";
            for(let i=0; i<tab.length; i++){
                document.getElementById(id).innerHTML += '<option value="'+tab[i]+'">'+tab[i]+'</option>';
            }

        }
    };
    xmlhttp.open("GET", "gethint.php", true);
    xmlhttp.send();
}


function main() {
    console.log("Start");
    showHint("ville3");
    showHint("ville2");


}
main();