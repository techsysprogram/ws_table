<?php

$IDO = explode("-", $_GET['ido']);
$ID_Org = $IDO[0]; //  $_GET['ido'];
$IDTirage = $IDO[1]; //   $_GET['ido'];
$str_stock = $IDO[2]; //   $_GET['ido'];
//    lo pongo vacio porque no es un PUT
$bRojo = false;
$data = "";
$tr_Rojo = "";

if ($str_stock != "0") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://boulier.techsysprogram.fr/TechAPI/StockVerifier/' . $ID_Org,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => $str_stock,
        CURLOPT_HTTPHEADER => array(
            'Token: Miguel',
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $arr = json_decode($response, true);

    //aqui con $response deberia poner una condicion para saber si el codigo es correcto
    // {
    //     "sType": "Chance",
    //     "sFormat": "chanceee",
    //     "nNombre": 5,
    //     "sEtat": "OK"
    // },

    foreach ($arr as $item) { //foreach element in $arr
        $etat = $item['sEtat'];
        if ($etat != "OK") {
            $bRojo = true;
            $tr_Rojo = $tr_Rojo . "|" . $item['sType'] . "|" . $item['sFormat'] . "|;";
        }
    }
}


$response = "";
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://boulier.techsysprogram.fr/TechAPI/TiragePlanches/' . $ID_Org . '/' . $IDTirage,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Token: Miguel'
    ),
));
$response = curl_exec($curl);
curl_close($curl);
?>

<?php
$html2 = "";
$html2 = $html2 . <<<FIN
    <!-- <div class="container"> -->
    <table class="table table-hover">
    <thead>
        <tr class="table-active">
            <th scope="col">Planche</th>
            <th scope="col">Prix</th>
            <th scope="col">Quantité</th>
        </tr>
    </thead>
    <tbody>
    FIN;

// $response aqui regreso los datos json del webservice

$arr = json_decode($response, true);
$etat = true;
$PlancheNom = "";

foreach ($arr as $item) { //foreach element in $arr
    $etat = $item['bEtat'];
    $Description = $item['sDescriptLong'];
    $PlancheNom = $item['sType'] . " - " . $item['sFormat'];
    $Planche_stock = "|" . $item['sType'] . "|" . $item['sFormat'] . "|";
    $Prix = $item['sPrix'] . " €";


    // if ($bRojo) {
    //     echo $tr_Rojo . '<br>' . $Planche_stock;
    //     die;
    // }


    if (strpos($tr_Rojo, $Planche_stock) !== false) {
        $html2 = $html2 . "<tr class='table-warning'>";
    } else {
        $html2 = $html2 . "<tr>";
    }


    // $html2 = $html2 . strpos('PHP is cool', 'cool') ? "<tr class='table-warning'>" : "<tr>";

    if ($etat) {
        $html2 = $html2 . "<td><p>$PlancheNom</p><p>$Description</p></td>";
        $html2 = $html2 . "<td>$Prix</td>";
        $html2 = $html2 . <<<FIN
                <td>
                <select class="form-select" onchange="tech_enregistrer2()">
                <option value='0$Planche_stock'>0</option>
                <option value='1$Planche_stock'>1</option>
                <option value='2$Planche_stock'>2</option>
                <option value='3$Planche_stock'>3</option>
                <option value='4$Planche_stock'>4</option>
                <option value='5$Planche_stock'>5</option>
                <option value='6$Planche_stock'>6</option>
                <option value='7$Planche_stock'>7</option>
                <option value='8$Planche_stock'>8</option>
                <option value='9$Planche_stock'>9</option>
                </select>
                </td>
                FIN;
    }
    $html2 = $html2 . "</tr>";
}

$html2 = $html2 . <<<FIN
</tbody>
</table>
    <script>

    function tech_enregistrer2() {
    var cases = document.getElementsByClassName("form-select");    
    var str_test = "";
    var resultat = "";
    for (var i = 1; i < cases.length; i++) {
      str_test = cases[i].value;
      if (!str_test.includes("0|")) {
        resultat += cases[i].value + ";";
      }
    }
    <!--  console.log(resultat); -->

    var tech_org ="nuevo " + cases[0].value.split(" ").join("");
    window.localStorage.setItem(tech_org, resultat); 
    <!-- $("#Compra2").html(resultat); -->

     }</script>

<!--  <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>

 <div id="Compra2"></div>-->
 
FIN;


if ($bRojo == false and $str_stock != "0") {
    // {
    //     "sType": "Chance",
    //     "sFormat": "chanceee",
    //     "nNombre": 5,
    //     "sEtat": "OK"
    // },

    foreach ($arr as $item) { //foreach element in $arr
        $str_woo = $item['sType'] . ' - ' . $item['sFormat'] . '<br>';
        $html2 = $html2 . $str_woo;
    }
}

echo $html2;

?>