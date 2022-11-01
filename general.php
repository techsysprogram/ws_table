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

function executer_funcion_table_gerer()
{
    // Load plugin files.
    include "table_gerer.php";
}
add_shortcode('short_table_gerer', 'executer_funcion_table_gerer');


function executer_funcion_table_ventas()
{
    // Load plugin files.
    include "table_ventas.php";
}
add_shortcode('short_table_ventas', 'executer_funcion_table_ventas');

function executer_funcion_table()
{
    // Load plugin files.
    include "table.php";
}
add_shortcode('short_table', 'executer_funcion_table');
