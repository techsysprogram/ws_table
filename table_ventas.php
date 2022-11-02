<?php
require_once 'data/ws_table3.php';
?>

<body>

    <?php
    $arr = json_decode($response, true);
    $Tirage = "";
    $code = 0;

    $html2 = "<select class='form-select' name=watwiljedoen>";

    foreach ($arr as $item) { //foreach element in $arr
        $code = $item['nCode'];
        $Tirage = $item['dDateTirage'] . "  " . $item['sAlias'];
        $html2 = $html2 . <<<FIN
            <option value='$code'>$Tirage</option>
        FIN;
    }
    $html2 = $html2 . "</select>";
    echo $html2;

    ?>


    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="btnradio1">Nouvelles planches</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="btnradio3">Utiliser déjà mes planches 3</label>
    </div>



    <div id="Compra"></div>


    <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>

    <div id="Compra2"></div>
</body>