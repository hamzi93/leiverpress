<?php

global $bike_db_version;
$bike_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-bike.php');

/**
 * Datenbank erstellen
 */
function bike_install()
{
	global $wpdb;
	global $bike_db_version;

	$table_name = $wpdb->prefix . 'bike';
	$forgein_table_name = $wpdb->prefix . 'brand';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		bike_id mediumint(9) NOT NULL AUTO_INCREMENT,
		bike_name tinytext NOT NULL,
		bike_preis int NOT NULL,
		bike_rabatt BOOLEAN NOT NULL,
		bike_bild BLOB,
		brand_id mediumint(9) NOT NULL,
		PRIMARY KEY  (bike_id),
		FOREIGN KEY  (brand_id) REFERENCES $forgein_table_name(brand_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bike_db_version', $bike_db_version);
}


/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bike_install_data()
{
	global $wpdb;

	$bikes = Bike::getAllBikesFromJson();
	$table_name = $wpdb->prefix . 'bike';

	foreach ($bikes as $bike) {
		$bike_name = $bike->getName();
		$bike_preis = $bike->getPreis();
		$bike_rabatt = $bike->getRabatt();
		$bike_bild = file_get_contents(MY_PLUGIN_PATH . $bike->getBild());
		$brand_id = $bike->getBrandId();

		$wpdb->insert(
			$table_name,
			array(
				'bike_name' => $bike_name,
				'bike_preis' => $bike_preis,
				'bike_rabatt' => $bike_rabatt,
				'bike_bild' => $bike_bild,
				'brand_id' => $brand_id
			)
		);
	}
}

//register_activation_hook(MY_PLUGIN_FILE, 'bike_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
//register_activation_hook(MY_PLUGIN_FILE, 'bike_install_data'); //Daten werden in die Datenbank eingefügt