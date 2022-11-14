<?php
$IDO = $_GET['ido'];
$data = $_GET['vjson'];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://boulier.techsysprogram.fr/TechAPI/StockVerifier/' . $IDO,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
        'Token: Miguel',
        'Content-Type: application/json'
    ),
));

$response = "";
$response = curl_exec($curl);
curl_close($curl);

$arr = json_decode($response, true);
$PlancheNom = "";

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
        $PlancheNom = $PlancheNom . $item['sType'] . "|" . $item['sFormat'] . ";";
    }
}

echo $PlancheNom;
