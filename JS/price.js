let jour="";
let slideVal;

function maxPrice(str) {
    console.log("Maxprice");
    console.log(str);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test1");
            let tab=this.responseText;
            console.log(tab);

            console.log("test2");
            tab=JSON.parse(tab);

            document.getElementById("range").max = tab['maxprice'];
            document.getElementById("range").min = tab['minprice'];
            document.getElementById("range").value = tab['maxprice'];
            slideVal=tab['maxprice'];

            document.getElementById("textSlide").innerHTML = "Prix maximum: "+document.getElementById("range").value+" €";

        }
    };
    xmlhttp.open("GET", "getmaxprice.php?q="+str, false);
    xmlhttp.send();
}

function rangerVol(prix, order, str, search) {
    if (search === false){
        maxPrice(str);
        str="";
        prix=slideVal;
    }

    console.log("RangerVol");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test1");
            let result=this.responseText.split(',');
            console.log(result);
            result=JSON.parse(result);
            console.log(result);
            document.getElementById("allCard").innerHTML = "";
            if (order === 0)
            {
                document.getElementById("actualOrder").innerHTML = "Actuel : Decroissant";
            }else {
                document.getElementById("actualOrder").innerHTML = "Actuel : Croissant";
            }
            let compteur = 0;
            let tmp = 0;
            let nbr_Flight=result.length;
            console.log("Fligggggg"+nbr_Flight);
            let valeurSlide= document.getElementById("range").value; //Affichage load
            for (let k = 0; k < nbr_Flight; k++) {
                if (result[k]['price'] <=prix)
                {
                    if (result[k]['capacity'] === 0){
                        result[k]['capacity']=1;
                    }
                    if (order === 0){
                        document.getElementById("allCard").innerHTML = "<div class='card'>" +
                            "<h5 class='card-header'> Vol #"+result[k]['id']+"</h5>" +
                            "<div class='card-body'>" +
                            "<h5 class='card-title'><i class='fa fa-plane'></i> &nbsp;"+result[k]['departuretime']+" - "+result[k]['arrivaltime']+"</h5>" +
                            "<div class='row'>" +
                            "<div class='col'>" +
                            "<p class='card-text'><i class='fa fa-map-marker'></i>"+result[k]['origincity']+" ("+result[k]['sessionOP']+") à"+result[k]['destinationcity']+" ("+result[k]['sessionDP']+")<br><i class='fa fa-calendar'></i> "+result[k]['daypropre']+"</p>" +
                            "</div>"+
                            "<div class='col'>"+
                            "<p class='card-text'>Durée du voyage <br><i class='fa fa-clock-o' ></i>&nbsp;"+result[k]['travelTime']+"</div>"+
                            "<div class='col'>"+
                            "<p class='card-text'>Capacité Restante: "+result[k]['capacity']+"% <br> <div class='progress'>"+
                            "<div id='progress-bar' class='progress-bar bg-white' style='width:"+result[k]['capacity']+"%;color:white; background-color:orangered !important;' aria-valuemin='1' aria-valuemax='100'>"+result[k]['capacity']+" %</div>"+
                            "</div>"+
                            "</div>"+
                            "</div>"+
                            "<hr><h5 class='card-text'>À partir de "+result[k]['price']+"€</h5>"+
                            "<form method='POST' action='controller.php?func=selectedFlight&id="+result[k]['id']+"&price="+result[k]['price']+"&travelTime="+result[k]['travelTime']+"&capacity="+result[k]['capacity']+"'><button style='float:right; width:30%' type='submit' class='btn btn-outline-white'>Sélectionner</button></form>"+
                            "</div>"+
                            "</div><br>"+ document.getElementById("allCard").innerHTML;
                    }else{
                        document.getElementById("allCard").innerHTML = document.getElementById("allCard").innerHTML +"<div class='card'>" +
                            "<h5 class='card-header'> Vol #"+result[k]['id']+"</h5>" +
                            "<div class='card-body'>" +
                            "<h5 class='card-title'><i class='fa fa-plane'></i> &nbsp;"+result[k]['departuretime']+" - "+result[k]['arrivaltime']+"</h5>" +
                            "<div class='row'>" +
                            "<div class='col'>" +
                            "<p class='card-text'><i class='fa fa-map-marker'></i>"+result[k]['origincity']+" ("+result[k]['sessionOP']+") à"+result[k]['destinationcity']+" ("+result[k]['sessionDP']+")<br><i class='fa fa-calendar'></i> "+result[k]['daypropre']+"</p>" +
                            "</div>"+
                            "<div class='col'>"+
                            "<p class='card-text'>Durée du voyage <br><i class='fa fa-clock-o' ></i>&nbsp;"+result[k]['travelTime']+"</div>"+
                            "<div class='col'>"+
                            "<p class='card-text'>Capacité Restante: "+result[k]['capacity']+"% <br> <div class='progress'>"+
                            "<div id='progress-bar' class='progress-bar bg-white' style='width:"+result[k]['capacity']+"%;color:white; background-color:orangered !important;' aria-valuemin='1' aria-valuemax='100'>"+result[k]['capacity']+" %</div>"+
                            "</div>"+
                            "</div>"+
                            "</div>"+
                            "<hr><h5 class='card-text'>À partir de "+result[k]['price']+"€</h5>"+
                            "<form method='POST' action='controller.php?func=selectedFlight&id="+result[k]['id']+"&price="+result[k]['price']+"&travelTime="+result[k]['travelTime']+"&capacity="+result[k]['capacity']+"'><button style='float:right; width:30%' type='submit' class='btn btn-outline-white'>Sélectionner</button></form>"+
                            "</div>"+
                            "</div><br>";
                    }

                    compteur++;
                }
                if (compteur === 0){
                    document.getElementById("allCard").innerHTML = "<div class='alert alert-primary' role='alert'>Aucun vol disponible pour ce prix</div>";
                }
                tmp++;
            }
            if (tmp === 0){
                document.getElementById("allCard").innerHTML = "<div class='alert alert-primary' role='alert'>Aucun vol disponible cette date</div>";
            }
            console.log("lel");
            console.log(result[0]['date2']);
            document.getElementById("jourActu").innerHTML = result[0]['date'];
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + (parseInt(dd)+1);

            console.log("Date = "+today);
            if (result[0]['date'] === today){
                document.getElementById("jourPre").disabled = true;
            }else {
                document.getElementById("jourPre").disabled = false;
            }
            document.getElementById("jourNext").innerHTML = "&raquo;";
            document.getElementById("jourPre").innerHTML = "&laquo;";



        }
    };
    xmlhttp.open("GET", "getprice.php?q="+str, true);
    xmlhttp.send();
}

window.onload = function() {
    console.log("Debut SQL");
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide,1, "", false);
    slideVal=document.getElementById("range").value;

};
function changeNumer(){
    document.getElementById("textSlide").innerHTML = "Prix maximum: "+document.getElementById("range").value+" €";
    console.log(document.getElementById("range").value);

}
function chargePage(){
    document.getElementById("allCard").innerHTML = "<div id='myNav' class='overlay' style='width: 100%'>" +
        "<div class='overlay-content'>" +
        "<div class='d-flex justify-content-center' style='color: orangered'>" +
        "<div class='spinner-border' role='status' style='width: 4rem; height: 4rem;'></div>" +
        "</div>" +
        "</div>" +
        "</div>";
}

function launchSearch(){
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide, 1, "", true);

}

function ASC(){
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide, 1,"", true);
}

function DESC() {
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide, 0, "", true);
}

function jourPre(){
    console.log("Click Prev");
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide,1, "-1", false);

}

function jourNext(){
    console.log("Click Next");
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide,1, "+1", false);
}

function jourActu(){
    console.log("Click Prev");
    chargePage();
    let valeurSlide= document.getElementById("range").value;
    rangerVol(valeurSlide,1, "", false);
}


function main() {
    console.log("Start");
    document.getElementById("range").addEventListener("change", changeNumer);

    document.getElementById("searchButton").addEventListener("click", launchSearch);


    document.getElementById("croissantButton").addEventListener("click", ASC);
    document.getElementById("decroissantButton").addEventListener("click", DESC);

    document.getElementById("jourPre").addEventListener("click", jourPre);
    document.getElementById("jourActu").addEventListener("click", jourActu);
    document.getElementById("jourNext").addEventListener("click", jourNext);



}
main();