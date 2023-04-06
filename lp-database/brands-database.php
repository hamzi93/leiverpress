<?php

global $brands_db_version;
$brands_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-brand.php');

/**
 * Datenbank erstellen
 */
function brands_install()
{
	global $wpdb;
	global $brands_db_version;

	$table_name = $wpdb->prefix . 'brands';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		brand_id mediumint(9) NOT NULL AUTO_INCREMENT,
        brand_name varchar(30) NOT NULL,
		PRIMARY KEY  (brand_id),
        UNIQUE KEY  (brand_name) 
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('brands_db_version', $brands_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function brands_install_data()
{
	global $wpdb;

	$brands = Brand::getAllBrandsFromJson();
	$table_name = $wpdb->prefix . 'brands';

	foreach ($brands as $brand) {
		$brandName = $brand->getName();
		$wpdb->insert(
			$table_name,
			array(
				'brand_name' => $brandName
			)
		);
	}
}


register_activation_hook(MY_PLUGIN_FILE, 'brands_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'brands_install_data'); //Daten werden in die Datenbank eingefügt