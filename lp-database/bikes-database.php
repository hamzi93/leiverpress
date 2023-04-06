<?php

global $bikes_db_version;
$bikes_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-bike.php');

/**
 * Datenbank erstellen
 */
function bikes_install()
{
	global $wpdb;
	global $bikes_db_version;

	$table_name = $wpdb->prefix . 'bikes';
	$forgein_table_name = $wpdb->prefix . 'bikedetails';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		bike_id mediumint(9) NOT NULL AUTO_INCREMENT,
		bike_licenseplate varchar(15) NOT NULL,
		bikedetail_id mediumint(9) NOT NULL,
		PRIMARY KEY  (bike_id),
		UNIQUE KEY  (bike_licenseplate), 
		FOREIGN KEY  (bikedetail_id) REFERENCES $forgein_table_name(bikedetail_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bikes_db_version', $bikes_db_version);
}


/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bikes_install_data()
{
	global $wpdb;

	$bikes = Bike::getAllBikesFromJson();
	$table_name = $wpdb->prefix . 'bikes';

	foreach ($bikes as $bike) {
		$bikeLicensePlate = $bike->getLicensePlate();
		$bikeDetailId = $bike->getBdId();

		$wpdb->insert(
			$table_name,
			array(
				'bike_licenseplate' => $bikeLicensePlate,
				'bikedetail_id' => $bikeDetailId
			)
		);
	}
}

register_activation_hook(MY_PLUGIN_FILE, 'bikes_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'bikes_install_data'); //Daten werden in die Datenbank eingefügt