<?php

//esto es lo que necesita para api woocommerce
require "/home/ynix0625/public_html/wp-content/plugins/Api_Techsysprogram/" . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

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

//////////////////////////////////////////////////////////// CREATE_PRODUCT
///ici je mes les donné seprados por espacio
$IDO = explode("|", $_GET['dp']);

$data = [
    'name' => $IDO[0],
    'type' => 'simple',
    'status' => 'publish',
    'description' => $IDO[1],
    'short_description' => $IDO[2],
    'regular_price' => $IDO[3],
    // 'sku' => $IDO[2],sku=UGS si se pone un valor unico y otro prodcto tiene el mismo nombre este no se guarda
    // 'categories' => [['id' => 18], ['id' => 16]],
    'categories' => [["name" => "gategor"]],
    'slug' => 'idoooo2' //esto es lo que se verra en el url ojo si ya existe este creara un url indexado ex: ..-3
];

$i_dex = 0;
foreach ($IDO as $array) {
    echo "IDO[" . $i_dex . "] = " . $array, '<br>';
    $i_dex++;
}

// $woocommerce->post('products', $data);

// Actualización en lotes
$result = $woocommerce->post('products', $data);

if (!$result) {
    echo ("❗Error al actualizar productos \n");
} else {
    print("✔ Productos actualizados correctamente \n");
}

// foreach ($data as $array) {
//     echo $array, '<br>';
// }

// $data2 = [
//     'name' => $producto, 'slug' => '<string>', 'date_created' => '<string>', 'date_created_gmt' => '<string>', 'type' => '["simple","simple"]',
//     'status' => '["publish","publish"]', 'featured' => '<string>', 'catalog_visibility' => '["visible","visible"]',
//     'description' => '<string>', 'short_description' => '<string>', 'sku' => '<string>', 'regular_price' => '<string>',
//     'sale_price' => '<string>', 'date_on_sale_from' => '<string>', 'date_on_sale_from_gmt' => '<string>', 'date_on_sale_to' => '<string>',
//     'date_on_sale_to_gmt' => '<string>', 'virtual' => '<string>', 'downloadable' => '<string>', 'downloads' => '<string>',
//     'download_limit' => '<string>', 'download_expiry' => '<string>', 'external_url' => '<uri>', 'button_text' => '<string>',
//     'tax_status' => '["taxable","taxable"]', 'tax_class' => '<string>', 'manage_stock' => '<string>', 'stock_quantity' => '<string>',
//     'stock_status' => '["instock","instock"]', 'backorders' => '["no","no"]', 'sold_individually' => '<string>', 'weight' => '<string>',
//     'dimensions' => '<string>', 'shipping_class' => '<string>', 'reviews_allowed' => '<string>', 'upsell_ids' => '<string>',
//     'cross_sell_ids' => '<string>',    'parent_id' => '<string>', 'purchase_note' => '<string>', 'categories' => '<string>',
//     'tags' => '<string>', 'images' => '<string>',    'attributes' => '<string>', 'default_attributes' => '<string>',
//     'menu_order' => '<string>', 'meta_data' => '<string>'
// ];

// Ajouter un produit automatiquement

$woocommerce->post('products', $data);


add_action('init', 'add_product_to_cart');
function add_product_to_cart()
{
    if (!is_admin()) {
        global $woocommerce;
        $product_id = 22;
        $found = false;
        //On vérifie si il y a déja un produit dans le panier
        if (sizeof($woocommerce->cart->get_cart()) > 0) {
            foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
                $_product = $values['data'];
                if ($_product->id == $product_id) $found = true;
            }
            if (!$found) $woocommerce->cart->add_to_cart($product_id);
        } else {
            $woocommerce->cart->add_to_cart($product_id);
        }
    }
}


<?php
function MY_add_to_cart_action()
{
	if ( ! empty( $_REQUEST['multiple-add-to-cart'] ) ) {
		$my_products = explode( '-', $_REQUEST['multiple-add-to-cart'] ) ; 
		foreach ( $my_products as $my_product )
		{
			$product    = wc_get_product( $my_product );
			if ( $product && $product->is_purchasable() )
			{
				WC()->cart->add_to_cart( $product->id, 1 ) ;
			}
		}
		wp_redirect( 'panier' );
		exit;
	}
}
add_action( 'wp_loaded', 'MY_add_to_cart_action', 20 );

https://www.resto123.com/boutique/?add-to-cart=298&&quantity=2
