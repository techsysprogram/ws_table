<?php
//$valueNom =  $('#pr_nom').val();
$valueNom =  "hol";

// $IDTirage = "42";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $IDTirage = $_REQUEST('idt');
//     if (empty($IDTirage)) {
//         $IDTirage = "42";
//     }
// }

$IDTirage =  $_GET['idt'];

$data = <<<DATA
   { 
       "nIDJouer":0, 
       "nIDJouerLoto":0, 
       "sAdresse":"BUENOS AIRES 234 ", 
       "sCNI":"", "nCodePostal":31004, 
       "dDateNaissance":"0000-00-00", 
       "seMail":"contact@techsysprogram.com", 
       "sMobile":"33333333333", 
       "sNom":"$valueNom", 
       "sPrenom":"SAAAAAAUL", 
       "sTelephone":"03436986700", 
       "dhUltimoCambio":"2022-05-06T21:15:25.150", 
       "sVille":"PARANA", 
       "sMotDePasse":"2001Dolores", 
       "bBorrado":false, 
       "sPays":"" 
   }
   DATA;
//    lo pongo vacio porque no es un PUT
$data = "";

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://boulier.techsysprogram.fr/TechAPI/JoueurPlanche/9905/' . $IDTirage . '/techsysprogram@gmail.com',
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
$response = "";
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
            <th scope="col"></th>
            <th scope="col">Planche</th>
            <th scope="col">Code</th>
            <th scope="col">Prix</th>
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
    $Codebarre = $item['sCodeBarre'];
    $PlancheNom = $item['sPlancheType'] . " - " . $item['sPlancheFormat'];
    $Prix = $item['sPlanchePrix'] . " €";

    //aqui separa la liena en 3 partes codebarre,actif!,number
    $html2 = $html2 . ($etat ? "<tr class='table-success'>" : "<tr>");

    if (!$etat) {
        $html2 = $html2 . <<< FIN
            <th scope='row'>
            <div class="form-check">
            <input class="form-check-input" type="checkbox" name="check01" value=$Codebarre>
            FIN;
    } else {
        $html2 = $html2 . "<th>";
    }
    $html2 = $html2 . "</th>";
    $html2 = $html2 . "<td>$PlancheNom</td>";
    //$html2 = $html2 . "<td>$Codebarre</td>";
    if ($etat) {
        $html2 = $html2 . "<td><a href='http://planches.techsysprogram.fr/LotoWS/PDFRecuperer/PL-$Codebarre.pdf' target='_blank'> <button class='btn btn-success' vertical-align:bottom> $Codebarre</button> </a></td>";
    } else {
        $html2 = $html2 . "<td>$Codebarre</td>";
    }
    $html2 = $html2 . "<td>$Prix</td>";

    $html2 = $html2 . "</tr>";
}

$html2 = $html2 . "</tbody></table>";

echo $html2;
?>