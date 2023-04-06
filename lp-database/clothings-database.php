<?php

global $clothings_db_version;
$clothings_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-clothing.php');

/**
 * Datenbank erstellen
 */
function clothings_install()
{
	global $wpdb;
	global $clothings_db_version;

	$table_name = $wpdb->prefix . 'clothings';
    $forgein_table_detail = $wpdb->prefix . 'clothingdetails';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		clothing_id mediumint(9) NOT NULL AUTO_INCREMENT,
        clothing_size varchar(10) NOT NULL,
        clothingdetail_id mediumint(9) NOT NULL,
		PRIMARY KEY  (clothing_id),
        FOREIGN KEY  (clothingdetail_id) REFERENCES $forgein_table_detail(clothingdetail_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('clothings_db_version', $clothings_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function clothings_install_data()
{
	global $wpdb;

	$clothings = Clothing::getAllClothingFromJson();
	$table_name = $wpdb->prefix . 'clothings';

	foreach ($clothings as $clothing) {
		$clothingSize = $clothing->getSize();
        $clothingDetailId = $clothing->getCdId();
		$wpdb->insert(
			$table_name,
			array(
				'clothing_size' => $clothingSize,
                'clothingdetail_id' => $clothingDetailId
			)
		);
	}
}


//register_activation_hook(MY_PLUGIN_FILE, 'clothings_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
//register_activation_hook(MY_PLUGIN_FILE, 'clothings_install_data'); //Daten werden in die Datenbank eingefügt