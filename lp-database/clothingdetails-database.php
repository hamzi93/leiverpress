<?php

global $clothingdetails_db_version;
$clothingdetails_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-clothingdetail.php');

/**
 * Datenbank erstellen
 */
function clothingdetails_install()
{
	global $wpdb;
	global $clothingdetails_db_version;

	$table_name = $wpdb->prefix . 'clothingdetails';
    $forgein_table_category = $wpdb->prefix . 'clothingcategory';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		clothingdetail_id mediumint(9) NOT NULL AUTO_INCREMENT,
        clothingdetail_name varchar(55) NOT NULL,
        clothingdetail_image BLOB, 
        clothingdetail_description text, 
        clothingcategory_id smallint NOT NULL,
		PRIMARY KEY  (clothingdetail_id),
        UNIQUE KEY  (clothingdetail_name),
        FOREIGN KEY  (clothingcategory_id) REFERENCES $forgein_table_category(clothingcategory_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('clothingdetails_db_version', $clothingdetails_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function clothingdetails_install_data()
{
	global $wpdb;

	$clothingDetails = ClothingDetail::getAllClothingDetailFromJson();
	$table_name = $wpdb->prefix . 'clothingdetails';

	foreach ($clothingDetails as $clothingDetail) {
		$clothingDetailName = $clothingDetail->getName();
        $clothingDetailImage = file_get_contents(MY_PLUGIN_PATH . $clothingDetail->getImage());
        $clothingDetailDescription = $clothingDetail->getDescription();
        $clothingCategoryId = $clothingDetail->getCcId();
		$wpdb->insert(
			$table_name,
			array(
				'clothingdetail_name' => $clothingDetailName,
                'clothingdetail_image' => $clothingDetailImage,
                'clothingdetail_description' => $clothingDetailDescription,
                'clothingcategory_id' => $clothingCategoryId
			)
		);
	}
}


//register_activation_hook(MY_PLUGIN_FILE, 'clothingdetails_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
//register_activation_hook(MY_PLUGIN_FILE, 'clothingdetails_install_data'); //Daten werden in die Datenbank eingefügt