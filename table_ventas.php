<?php

$ID_Org =  $_GET['ido'];
if (empty($ID_Org)) {
    $ID_Org = 9905;
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://boulier.techsysprogram.fr/TechAPI/Tirages/' . $ID_Org,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    // CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Token: Miguel'
    ),
));
$response = "";
$response = curl_exec($curl);
curl_close($curl);
?>


<body>

    <?php
    $arr = json_decode($response, true);
    $Tirage = "";
    $code = 0;

    $html2 = "<select class='form-select' name=tech_select_tirage>";

    foreach ($arr as $item) { //foreach element in $arr
        $code = $item['nCode'];
        $Tirage = $item['dDateTirage'] . "  " . $item['sAlias'] . "   => " . $code;
        $html2 = $html2 . <<<FIN
            <option value='$code'>$Tirage</option>
        FIN;
    }
    $html2 = $html2 . "</select><h1></h1>";
    echo $html2;

    ?>

    <!-- nuevas o utilisadas -->
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="btnradio1">Nouvelles planches</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="btnradio2">Utiliser déjà mes planches</label>
    </div>
    <h1></h1>


    <div id="tech_id_table"></div>


    <!-- <button class="btn btn-primary" name="valider" id="btnEnregistrer">Enregistrer planches</button>-->
    <button class="btn btn-primary" name="valider3" id="btnStock">verificar stock</button>

    <div id="Compra2"></div>
</body>