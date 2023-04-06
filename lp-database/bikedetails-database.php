<?php

global $bikedetails_db_version;
$bikedetails_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-bikedetail.php');

/**
 * Datenbank erstellen
 */
function bikedetails_install()
{
	global $wpdb;
	global $bikedetails_db_version;

	$table_name = $wpdb->prefix . 'bikedetails';
	$forgein_table_brand = $wpdb->prefix . 'brands';
    $forgein_table_license = $wpdb->prefix . 'bikelicenses';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		bikedetail_id mediumint(9) NOT NULL AUTO_INCREMENT,
        bikedetail_modelname varchar(255) NOT NULL,
        bikedetail_modelyear varchar(255),
        bikedetail_image BLOB,
        bikedetail_dayprice int NOT NULL,
        bikedetail_discount int,
        bikedetail_discountdays smallint,
        bikedetail_performanceps varchar(10),
        bikedetail_engine varchar(30),
        bikedetail_torque varchar(30),
        bikedetail_capacity varchar(30),
        bikedetail_weight varchar(10),
		brand_id mediumint(9) NOT NULL,
        bikelicense_id tinyint NOT NULL,
		PRIMARY KEY  (bikedetail_id),
		UNIQUE KEY  (bikedetail_modelname),
		FOREIGN KEY  (brand_id) REFERENCES $forgein_table_brand(brand_id),
        FOREIGN KEY  (bikelicense_id) REFERENCES $forgein_table_license(bikelicense_id) 
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bikedetails_db_version', $bikedetails_db_version);
}


/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bikedetails_install_data()
{
	global $wpdb;

	$bikeDetails = BikeDetail::getAllBikeDetailsFromJson();
	$table_name = $wpdb->prefix . 'bikedetails';

	foreach ($bikeDetails as $bikeDetail) {

		$wpdb->insert(
			$table_name,
			array(
				'bikedetail_modelname' => $bikeDetail->getModelname(),
				'bikedetail_modelyear' => $bikeDetail->getModelyear(),
				'bikedetail_image' => file_get_contents(MY_PLUGIN_PATH . $bikeDetail->getImage()),
				'bikedetail_dayprice' => $bikeDetail->getDayprice(),
				'bikedetail_discount' => $bikeDetail->getDiscount(),
                'bikedetail_discountdays' => $bikeDetail->getDisountdays(),
                'bikedetail_performanceps' => $bikeDetail->getPerformancePs(),
                'bikedetail_engine' => $bikeDetail->getEngine(),
                'bikedetail_torque' => $bikeDetail->getTorque(),
                'bikedetail_capacity' => $bikeDetail->getCapacity(),
                'bikedetail_weight' => $bikeDetail->getWeight(),
                'brand_id' => $bikeDetail->getBrId(),
                'bikelicense_id' => $bikeDetail->getBlId()
			)
		);
	}
}

register_activation_hook(MY_PLUGIN_FILE, 'bikedetails_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'bikedetails_install_data'); //Daten werden in die Datenbank eingefügt