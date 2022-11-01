<?php
require_once 'data/ws_table.php';
?>

<body>
    <!-- <div class="container"> -->
    <table class="table table-hover">
        <thead>
            <tr class="table-active">
                <th scope="col"></th>
                <th scope="col">Planche</th>
                <th scope="col">Numéro</th>
                <th scope="col">descarga</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // $response aqui regreso los datos json del webservice
            $html2 = "";
            // $arr = json_decode('[{"var1":"9","var2":"16","var3":"16"},{"var1":"8","var2":"15","var3":"15"}]');

            $arr = json_decode($response, true);
            $etat = true;
            $PlancheNom = "";

            foreach ($arr as $item) { //foreach element in $arr
                $etat = $item['bEtat'];
                $Codebarre = $item['sCodeBarre'];
                $PlancheNom = $item['sPlancheDescrip'] . " - " . $item['sPlancheType'];

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
                $html2 = $html2 . "</tr>";
            }
            echo $html2;
            ?>

        </tbody>
    </table>


    <button class="btn btn-primary" name="valider" id="btnanswer">Acheter123!!!</button>
    <div id="answer"></div>
</body>