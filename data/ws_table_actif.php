<?php
//esto es lo que necesita para api woocommerce
require "/home/ynix0625/public_html/wp-content/plugins/Api_Techsysprogram/" . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

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
$str_stock = $IDO[2]; //   $_GET['ido'];  aqui tengo las planches
$str_actif = $IDO[3]; //   $_GET['ido'];  aqui los codigo de barras
$str_titulo = $_GET['titre']; //   $_GET['ido'];
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

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://boulier.techsysprogram.fr/TechAPI/JoueurPlanche/' . $ID_Org . "/" . $IDTirage . '/techsysprogram@gmail.com',
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
            <th scope="col">Code</th>
            <th scope="col">Prix</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    FIN;

// $response aqui regreso los datos json del webservice

$arr2 = json_decode($response, true);
$etat = true;
$PlancheNom = "";

foreach ($arr2 as $item) { //foreach element in $arr
    $etat = $item['bEtat'];
    $Codebarre = $item['sCodeBarre'];
    $Codebarre_val =  $Codebarre . "|" . $item['sPlancheType'] . "|" . $item['sPlancheFormat'] . "|" . $item['sPlanchePrix'] . "|";
    $PlancheNom = $item['sPlancheType'] . " - " . $item['sPlancheFormat'];
    $Prix = $item['sPlanchePrix'] . " €";

    //aqui separa la liena en 3 partes codebarre,actif!,number
    $html2 = $html2 . ($etat ? "<tr class='table-success'>" : "<tr>");

    $html2 = $html2 . "<td>$PlancheNom</td>";
    //$html2 = $html2 . "<td>$Codebarre</td>";
    if ($etat) {
        $html2 = $html2 . "<td><a href='http://planches.techsysprogram.fr/LotoWS/PDFRecuperer/PL-$Codebarre.pdf' target='_blank'> <button class='btn btn-success' vertical-align:bottom> $Codebarre</button> </a></td>";
    } else {
        $html2 = $html2 . "<td>$Codebarre</td>";
    }
    $html2 = $html2 . "<td>$Prix</td>";

    if (!$etat) {
        $html2 = $html2 . <<< FIN
            <th scope='row'>
            <div class="form-check" >
            <input class="form-check-input" onchange="tech_enregistrer2()" type="checkbox" name="check01" value=$Codebarre_val>
            FIN;
    } else {
        $html2 = $html2 . "<th>";
    }
    $html2 = $html2 . "</th>";


    $html2 = $html2 . "</tr>";
}

$html2 = $html2 . <<<FIN
</tbody>
</table>
    <script>
    
    function tech_enregistrer2() {
        var cases = document.getElementsByClassName("form-check-input");
        let resultat = "";
        for (var i = 0; i < cases.length; i++) {
          if (cases[i].checked) {
            resultat += cases[i].value + ";";
          }
        }
        cases = document.getElementsByClassName("form-select");
        var tech_org ="activar " +  cases[0].value.split(" ").join("");

        window.localStorage.setItem(tech_org, resultat);        
        $("#Compra2").html(resultat);

     }</script>

<!--  <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>

 <div id="Compra2"></div>-->
 
FIN;



if ($bRojo == false && ($str_stock != "0" || $str_actif != "0")) {

    $SiteWeb = 'https://www.resto123.com';
    $NewPost = $SiteWeb . '/wp-json/wc/v3/products';
    $User = 'ck_9c01c8ab107657ed70121a0714a18d9862d3bf0d';
    $Pass = 'cs_cb5ebcee1fee7cedbf61fc7b5b83ae41c9164353';

    $woocommerce = new Client(
        $SiteWeb,
        $User,
        $Pass,
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
        ]
    );


    if ($str_stock != "0") {
        $code_planches_qte = explode(";", $str_stock);

        foreach ($code_planches_qte as $value) {
            $code_planches_qte2 = explode("|", $value);
            //isset quiere decir que hay un valor existente sinon no continua
            if (isset($code_planches_qte2[3])) {

                $str_woo = $code_planches_qte2[1] . ' - ' . $code_planches_qte2[2] . ' x ' . $code_planches_qte2[0];
                // $html2 = $html2 . $str_woo . ' | ';

                $data = [
                    'name' => $str_titulo . ' ' .  $str_woo,
                    'type' => 'simple',
                    'status' => 'publish',
                    // 'description' => $item['sDescriptLong'],
                    // 'short_description' => $item['sDescriptLong'],
                    'regular_price' => $code_planches_qte2[3],
                    // 'sku' =>  $ID_Org . '-' . $IDTirage . ' ' . $str_woo, //sku=UGS si se pone un valor unico y otro prodcto tiene el mismo nombre este no se guarda
                    // 'categories' => [['id' => 18], ['id' => 16]],
                    'categories' => [["name" => "gategor"]]
                    // 'stock_quantity' => $item['nNombre']
                    //'slug' => 'idoooo2' esto es lo que se verra en el url ojo si ya existe este creara un url indexado ex: ..-3
                ];
                // Actualización en lotes

                try {
                    $result = $woocommerce->post('products', $data);
                    // print_r($result);
                    if (!$result) {
                        echo ("❗Error al actualizar productos \n");
                    } else {
                        print("✔ Productos actualizados correctamente siiii \n");

                        $duplicated_product = json_decode(json_encode($result), true);
                        // $prod_id2 = $prod_id2 .  $duplicated_product['id'] . "|";

                        // global $woocommerce;
                        $product_id = $duplicated_product['id'];
                        // $found = false;
                        //On vérifie si il y a déja un produit dans le panier
                        // if (sizeof($woocommerce->cart->get_cart()) > 0) {
                        //     foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
                        //         $_product = $values['data'];
                        //         if ($_product->id == $product_id) $found = true;
                        //     }
                        //     if (!$found) $woocommerce->cart->add_to_cart($product_id);
                        // } else {
                        // }
                        // $woocommerce->cart->add_to_cart($product_id);
                        // ajouterArticle($product_id, 1, 5);
                        // $woocommerce->cart->add_to_cart($product_id);
                        // $rep = $woocommerce->cart->add_to_cart('306');
                        // global $woocommerce;
                        // die( /*returns updated shopping cart */);
                    }


                    // perform some task
                } catch (Exception $ex) {
                    print("❗Error \n");
                    // jump to this part
                    // if an exception occurred
                }
            }
        }
    }


    //aqui para crear productos para activar panches existentes
    if ($str_actif != "0") {
        $code_planches_qte = explode(";", $str_actif);

        foreach ($code_planches_qte as $value) {
            $code_planches_qte2 = explode("|", $value);
            //isset quiere decir que hay un valor existente sinon no continua
            if (isset($code_planches_qte2[3])) {

                $str_woo = $code_planches_qte2[1] . ' - ' . $code_planches_qte2[2] . ' ( ' . $code_planches_qte2[0] . ' ) ';
                // $html2 = $html2 . $str_woo . ' | ';

                $data = [
                    'name' => $str_titulo . ' ' .  $str_woo,
                    'type' => 'simple',
                    'status' => 'publish',
                    // 'description' => $item['sDescriptLong'],
                    // 'short_description' => $item['sDescriptLong'],
                    'regular_price' => $code_planches_qte2[3],
                    // 'sku' =>  $ID_Org . '-' . $IDTirage . ' ' . $str_woo, //sku=UGS si se pone un valor unico y otro prodcto tiene el mismo nombre este no se guarda
                    // 'categories' => [['id' => 18], ['id' => 16]],
                    'categories' => [["name" => "gategor"]]
                    // 'stock_quantity' => $item['nNombre']
                    //'slug' => 'idoooo2' esto es lo que se verra en el url ojo si ya existe este creara un url indexado ex: ..-3
                ];
                // Actualización en lotes

                try {
                    $result = $woocommerce->post('products', $data);
                    // echo $result;
                    if (!$result) {
                        echo ("❗Error al actualizar productos \n");
                    } else {
                        print("✔ Productos actualizados correctamente \n");
                        $duplicated_product = json_decode(json_encode($result), true);
                        // $prod_id2 = $prod_id2 .  $duplicated_product['id'] . "|";

                        // global $woocommerce;
                        $product_id = $duplicated_product['id'];
                        //On vérifie si il y a déja un produit dans le panier

                    }
                    // perform some task
                } catch (Exception $ex) {
                    print("❗Error \n");
                    // jump to this part
                    // if an exception occurred
                }
            }
        }
    }
}

echo $html2;
?>