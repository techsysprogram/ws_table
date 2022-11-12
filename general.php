<?php
/*
Plugin Name: Api techsysprogram
Description: Créer des produits sur un autre site via l'API WooCommerce
Author: techsysprogram
Version: 1.1
Plugin URI: https://www.techsysprogram.com/
Author URI: https://www.techsysprogram.com/
*/

if (!defined('ABSPATH')) {
    exit;
}

//aqui el comienzo de short code
function executer_funcion_table_ventas()
{
    // Load plugin files.
    include "table_ventas.php";
}
add_shortcode('short_table_ventas', 'executer_funcion_table_ventas');
