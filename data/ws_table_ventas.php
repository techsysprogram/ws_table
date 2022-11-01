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
    CURLOPT_URL => 'http://boulier.techsysprogram.fr/TechAPI/TiragePlanches/9905/' . $IDTirage,
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
echo $response;
