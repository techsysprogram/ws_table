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
$IDO = explode("-", $_GET['ido']);
$ID_Org = $IDO[0]; //  $_GET['ido'];
$IDTirage = $IDO[1]; //   $_GET['idt'];

//    lo pongo vacio porque no es un PUT
$data = "";

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
    $html2 = $html2 . "<tr>";
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
    $("#Compra2").html(resultat);

     }</script>

<!--  <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>

 <div id="Compra2"></div>-->
 
FIN;
echo $html2;
?>