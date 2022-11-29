<?php

session_start();
include_once("lien_panier.php");

//esto es lo que necesita para api woocommerce
require "/home/ynix0625/public_html/wp-content/plugins/Api_Techsysprogram/" . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;


$IDO = explode("-", $_GET['ido']);
$ID_Org = $IDO[0]; //  $_GET['ido'];
$IDTirage = $IDO[1]; //   $_GET['ido'];
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
    $Planche_stock = "|" . $item['sType'] . "|" . $item['sFormat'] . "|" . $item['sPrix'] . "|";
    $Planche_stock2 = "|" . $item['sType'] . "|" . $item['sFormat'] . "|";
    $Prix = $item['sPrix'] . " €";


    // if ($bRojo) {
    //     echo $tr_Rojo . '<br>' . $Planche_stock . '<br>';
    //     // die;
    // }

    //no es capricho deja siempre el !==false
    if (strpos($tr_Rojo, $Planche_stock2) !== false) {
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

            $("#Compra2").html(resultat);
        }
     </script>

<!--  <button class="btn btn-primary" name="valider" id="btnCompra">Mettre au panier</button>

 <div id="Compra2"></div>-->
 
FIN;


$prod_id2 = "";
$tech_org = $ID_Org . '-' . $IDTirage;

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

// window.localStorage.setItem($tech_org, $prod_id2);     
echo $html2;

?>