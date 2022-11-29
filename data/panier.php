<?php

session_start();
include_once("lien_panier.php");

$erreur = false;

$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null));
if ($action !== null) {
    if (!in_array($action, array('ajout', 'suppression', 'refresh')))
        $erreur = true;

    $produit_Id = (isset($_GET['produit_Id']) ? $_GET['produit_Id'] : null);
    $produit_Prix = (isset($_GET['produit_Prix']) ? $_GET['produit_Prix'] : null);
    $produit_Quantite = (isset($_GET['produit_Quantite']) ? $_GET['produit_Quantite'] : null);

    $produit_Id = preg_replace('#\v#', '', $produit_Id);

    $produit_Prix = floatval($produit_Prix);

    if (is_array($produit_Quantite)) {
        $QteArticle = array();
        $i = 0;
        foreach ($q as $contenu) {
            $QteArticle[$i++] = intval($contenu);
        }
    } else
        $produit_Quantite = intval($produit_Quantite);
}

if (!$erreur) {
    switch ($action) {
        case "ajout":
            ajouterArticle($produit_Id, $produit_Quantite, $produit_Prix);
            break;

        case "suppression":
            supprimerArticle($produit_Id);
            break;

        case "refresh":
            for ($i = 0; $i < count($QteArticle); $i++) {
                modifierQTeArticle($_SESSION['panier']['produit_Id'][$i], round($QteArticle[$i]));
            }
            break;

        default:
            break;
    }
}

echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
    <title>Votre panier</title>
</head>

<body>

    <form method="post" action="panier.php">
        <table style="width: 400px">
            <tr>
                <td colspan="4">Votre panier</td>
            </tr>
            <tr>
                <td>Référence</td>
                <td>Quantité</td>
                <td>Prix Unitaire</td>
                <td>Action</td>
            </tr>


            <?php
            if (creationPanier()) {
                $nbArticles = count($_SESSION['panier']['produit_Id']);
                if ($nbArticles <= 0)
                    echo "<tr><td>Votre panier est vide </ td></tr>";
                else {
                    for ($i = 0; $i < $nbArticles; $i++) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($_SESSION['panier']['produit_Id'][$i]) . "</ td>";
                        echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"" . htmlspecialchars($_SESSION['panier']['produit_Quantite'][$i]) . "\"/></td>";
                        echo "<td>" . htmlspecialchars($_SESSION['panier']['prixProduit'][$i]) . "</td>";
                        echo "<td><a href=\"" . htmlspecialchars("panier.php?action=suppression&l=" . rawurlencode($_SESSION['panier']['produit_Id'][$i])) . "\">XX</a></td>";
                        echo "</tr>";
                    }

                    echo "<tr><td colspan=\"2\"> </td>";
                    echo "<td colspan=\"2\">";
                    echo "Total : " . MontantGlobal();
                    echo "</td></tr>";

                    echo "<tr><td colspan=\"4\">";
                    echo "<input type=\"submit\" value=\"Rafraichir\"/>";
                    echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

                    echo "</td></tr>";
                }
            }
            ?>
        </table>
    </form>
</body>

</html>