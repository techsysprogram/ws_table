<!--
https://www.ma-conciergerie.techsysprogram.com/page-test
-->
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



    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $IDTirage = $_REQUEST('idt');
    //     if (empty($IDTirage)) {
    //         $IDTirage = "42";
    //     }
    // }

    $IDTirage = $_GET['idt'];
    echo 'me esta dando ' . $IDTirage;
    ?>


    <?php

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
    // echo $response;
    ?>


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

            <?php
            // $response aqui regreso los datos json del webservice
            $html2 = "";

            $arr = json_decode($response, true);
            $etat = true;
            $PlancheNom = "";

            foreach ($arr as $item) { //foreach element in $arr
                $etat = $item['bEtat'];
                $Description = $item['sDescriptLong'];
                $PlancheNom = $item['sDescription'] . " - " . $item['sType'];
                $Prix = $item['rPrix'] . " €";
                $html2 = $html2 . "<tr>";
                if ($etat) {
                    $html2 = $html2 . "<td><p>$PlancheNom</p><p>$Description</p></td>";
                    $html2 = $html2 . "<td>$Prix</td>";
                    $html2 = $html2 . <<<FIN
                    <td>
                    <select class="form-select">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    </select>
                    </td>
                    FIN;
                }
                $html2 = $html2 . "</tr>";
            }
            echo $html2;
            ?>
        </tbody>
    </table>

    <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>
    <div id="Compra"></div>
</body>