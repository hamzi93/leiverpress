<?php

global $clothingcategory_db_version;
$clothingcategory_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-clothingcategory.php');

/**
 * Datenbank erstellen
 */
function clothingcategory_install()
{
	global $wpdb;
	global $clothingcategory_db_version;

	$table_name = $wpdb->prefix . 'clothingcategory';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		clothingcategory_id smallint NOT NULL AUTO_INCREMENT,
        clothingcategory_name varchar(30) NOT NULL,
		PRIMARY KEY  (clothingcategory_id) 
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('clothingcategory_db_version', $clothingcategory_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function clothingcategory_install_data()
{
	global $wpdb;

	$clothingCategorys = ClothingCategory::getAllClothingCategoryFromJson();
	$table_name = $wpdb->prefix . 'clothingcategory';

	foreach ($clothingCategorys as $clothingCategory) {
		$clothingCategory_name = $clothingCategory->getName();
		$wpdb->insert(
			$table_name,
			array(
				'clothingcategory_name' => $clothingCategory_name
			)
		);
	}
}


//register_activation_hook(MY_PLUGIN_FILE, 'clothingcategory_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
//register_activation_hook(MY_PLUGIN_FILE, 'clothingcategory_install_data'); //Daten werden in die Datenbank eingefügt