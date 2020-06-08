<?php

require_once 'connexpdo.php';

if (isset($_GET["func"]))
{
    if ($_GET["func"]=="readFlights"){
        readFlights($_POST['originAirport'], $_POST['destinationAirport'], $_POST['departDate'], $_POST['nbrAdultes'], $_POST['nbrEnfants'], $_POST['volDirectCheck']);
    }
}

function redirectFlights($depart, $arrivee, $date, $nbrAdults, $nbrEnfants, $volDirect){
    $_SESSION['originAirport']=$depart;

}

function buildForm() {

    if (isset($_POST['originAirport']) && isset($_POST['destinationAirport']) && isset($_POST['departDate']) && isset($_POST['nbrAdultes']) && isset($_POST['nbrEnfants'])) {
        $nombreAdultes = $_POST['nbrAdultes'];
        $nombreEnfants = $_POST['nbrEnfants'];

        //$bdd = connexpdo('pgsql:dbname=avion;host=localhost;port=5432', 'postgres', 'new_password');
        //$query = $bdd->prepare("SELECT state FROM taxes WHERE city = " . $_POST['originAirport']);
        //$query->execute();
        //$result = $query->fetch();
        //print_r($result[0]);
        echo '<form action = "">';
        for ($i = 0; $i < $nombreAdultes; $i++) {
            CreateFormAdult($i + 1);
        }
        for ($i = 0; $i < $nombreEnfants; $i++) {
            CreateFormEnfant($i + 1);
        }
        echo '<button type ="submit" class="btn btn-lg btn-white" style="width: 66%">Valider</button>';
        echo '</form>';
    }
}

function readFlights($depart, $arrivee, $date, $nbrAdults, $nbrEnfants, $volDirect){
    global  $db;
    $nbr_student=0;

    $query0 = "SELECT id FROM flights WHERE originairport =".$depart." AND destinationairport=".$arrivee;
    $nbr = $db->query($query0);
    foreach ($nbr as $data) {
        $nbr_student++;
    }
    echo "flights"+$date;

//
//    if($nbr_student>=1) {
//        echo'<table class="table">
//        <thead>
//            <tr>
//                <th scope="col">#</th>
//                <th scope="col">Nom</th>
//                <th scope="col">Prénom</th>
//                <th scope="col">Note</th>
//                <th scope="col"></th>
//                <th scope="col"></th>
//            </tr>
//        </thead>
//        <tbody>';
//
//        $query1 = "SELECT id, nom, prenom, note FROM students WHERE user_id =".$_SESSION["adminId"];
//        $sth = $db->prepare($query1);
//        $sth->execute();
//        $result=$sth->fetchAll();
//
//        for ($k = 0; $k < $nbr_student; $k++) {
//            $index=$k+1;
//            echo '<tr>';
//            echo '<th id="idStudent" scope="row">'.$index.'</th>';
//            echo '<td>' . $result[$k]['nom'] . '</td>';
//            echo '<td>' . $result[$k]['prenom'] . '</td>';
//            echo '<td>' . $result[$k]['note'] . '</td>';
//            echo '<td><form method="POST" action="vieweditstudent.php?id='.$result[$k]['id'].'"><button style="float: right" type="submit" class="btn btn-primary">Update</button></form></td>';
//            echo '<td><form method="POST" action="controller.php?func=DeleteStudent"><button style="float: right" name="Delete" value="'.$result[$k]['id'].'" type="submit" class="btn btn-danger">Delete</button></form></td>';
//            echo '</tr>';
//        }
//        echo '</tbody>';
//        echo '</table>';
//    }else{
//        return;
//    }
}

function CreateFormAdult($id){
    $today = getDate();
    $todayYear = $today['year'];
    $todayMonth = $today['mon'];
    $todayDay = $today['mday'];
    $lastYear = $todayYear-4;
    echo ' 
 <br>
 <div class="row">
    <div class="col col-md-8">
        <div class="card">
                    <div class="card-header">
                    Adulte n°'.$id.'
</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomAdult'.$id.'" placeholder="Nom">
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomAdult'.$id.'" placeholder="Prénom">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                            Adresse e-mail
                            <input type="email" class="form-control" name="emailAdult'.$id.'" placeholder="Adresse e-mail">
                        </div>
                        <div class="form-group col-md-6">
                          Date de Naissance
                          <input type="date" class="form-control" max="'.$lastYear.'-'.$todayMonth.'-'.$todayDay.'" name="birthAdult'.$id.'">
                        </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 ';
}

function CreateFormEnfant($id){
    $today = getDate();
    $todayYear = $today['year'];
    $todayMonth = $today['mon'];
    $todayDay = $today['mday'];
    $lastYear = $todayYear-4;
    echo ' 
 <br>
<div class="row">
    <div class="col col-md-8">
        <div class="card">
                            <div class="card-header">
                    Enfant n°'.$id.'
</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomEnfant'.$id.'" placeholder="Nom">
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomEnfant'.$id.'" placeholder="Prénom">
                    </div>
                </div>
                <div class="form-group">
                      Date de Naissance
                      <input type="date" class="form-control" min="'.$lastYear.'-'.$todayMonth.'-'.$todayDay.'" name="birthEnfant'.$id.'">
                </div>
            </div>
        </div>
    </div>
 </div>
 ';

}
