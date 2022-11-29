<?php
global $woocommerce;
//esto es lo que necesita para api woocommerce
require "/home/ynix0625/public_html/wp-content/plugins/Api_Techsysprogram/" . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

function creationPanier()
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
        $_SESSION['panier']['produit_Id'] = array();
        $_SESSION['panier']['produit_Quantite'] = array();
        $_SESSION['panier']['produit_Prix'] = array();
        $_SESSION['panier']['verrou'] = false;
    }
    return true;
}

function ajouterArticle($produit_Id, $produit_Quantite, $produit_Prix)
{
    // $product    = wc_get_product($produit_Id);
    // $product    = get_product($produit_Id);

    // if ($product && $product->is_purchasable()) {
    //     WC()->cart->add_to_cart($product->id, 1);
    // }

    // if (creationPanier() && !isVerrouille()) {
    $positionProduit = array_search($produit_Id,  $_SESSION['cart']['produit_Id']);

    print($positionProduit);
    if ($positionProduit !== false) {
        $_SESSION['cart']['produit_Quantite'][$positionProduit] += $produit_Quantite;
    } else {
        //Sinon on ajoute le produit
        print("estoy aqui");
        array_push($_SESSION['cart']['produit_Id'], $produit_Id);
        array_push($_SESSION['cart']['produit_Quantite'], $produit_Quantite);
        array_push($_SESSION['cart']['produit_Prix'], $produit_Prix);
    }
}

function modifierQTeArticle($produit_Id, $produit_Quantite)
{
    //Si le panier éxiste
    if (creationPanier() && !isVerrouille()) {
        //Si la quantité est positive on modifie sinon on supprime l'article
        if ($produit_Quantite > 0) {
            //Recharche du produit dans le panier
            $positionProduit = array_search($produit_Id,  $_SESSION['panier']['produit_Id']);

            if ($positionProduit !== false) {
                $_SESSION['panier']['produit_Quantite'][$positionProduit] = $produit_Quantite;
            }
        } else
            supprimerArticle($produit_Id);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function supprimerArticle($produit_Id)
{

    if (creationPanier() && !isVerrouille()) {
        //Nous allons passer par un panier temporaire
        $tmp = array();
        $tmp['produit_Id'] = array();
        $tmp['produit_Quantite'] = array();
        $tmp['produit_Prix'] = array();
        $tmp['verrou'] = $_SESSION['panier']['verrou'];

        for ($i = 0; $i < count($_SESSION['panier']['produit_Id']); $i++) {
            if ($_SESSION['panier']['produit_Id'][$i] !== $produit_Id) {
                array_push($tmp['produit_Id'], $_SESSION['panier']['produit_Id'][$i]);
                array_push($tmp['produit_Quantite'], $_SESSION['panier']['produit_Quantite'][$i]);
                array_push($tmp['produit_Prix'], $_SESSION['panier']['produit_Prix'][$i]);
            }
        }

        $_SESSION['panier'] =  $tmp;

        unset($tmp);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function MontantGlobal()
{
    $total = 0;
    for ($i = 0; $i < count($_SESSION['panier']['produit_Id']); $i++) {
        $total += $_SESSION['panier']['produit_Quantite'][$i] * $_SESSION['panier']['produit_Prix'][$i];
    }
    return $total;
}

function supprimePanier()
{
    unset($_SESSION['panier']);
}

function isVerrouille()
{
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
        return true;
    else
        return false;
}

function compterArticles()
{
    if (isset($_SESSION['panier']))
        return count($_SESSION['panier']['produit_Id']);
    else
        return 0;
}
