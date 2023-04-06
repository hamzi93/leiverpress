<?php

global $bikelicenses_db_version;
$bikelicenses_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-bikelicense.php');

/**
 * Datenbank erstellen
 */
function bikelicenses_install()
{
	global $wpdb;
	global $bikelicenses_db_version;

	$table_name = $wpdb->prefix . 'bikelicenses';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		bikelicense_id tinyint NOT NULL AUTO_INCREMENT,
		bikelicense_category char(4) NOT NULL,
		PRIMARY KEY  (bikelicense_id),
		UNIQUE KEY  (bikelicense_category) 
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bikelicenses_db_version', $bikelicenses_db_version);
}


/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bikelicenses_install_data()
{
	global $wpdb;

	$bikeLicenses = BikeLicense::getAllBikeLicenseFromJson();
	$table_name = $wpdb->prefix . 'bikelicenses';

	foreach ($bikeLicenses as $bikeLicense) {
		$bikeLicenseCategory = $bikeLicense->getCategory();

		$wpdb->insert(
			$table_name,
			array(
				'bikelicense_category' => $bikeLicenseCategory
			)
		);
	}
}

register_activation_hook(MY_PLUGIN_FILE, 'bikelicenses_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'bikelicenses_install_data'); //Daten werden in die Datenbank eingefügt