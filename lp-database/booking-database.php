<?php

global $booking_db_version;
$booking_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-booking.php');
require_once(MY_PLUGIN_PATH . 'lp-models/class-bike.php');

/**
 * Datenbank erstellen
 */
function booking_install()
{
	global $wpdb;
	global $booking_db_version;

	$table_name = $wpdb->prefix . 'booking';
	$forgein_table_name = $wpdb->prefix . 'bike';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		booking_id mediumint(9) NOT NULL AUTO_INCREMENT,
        booking_abholdatum datetime DEFAULT '0000-00-00 00:00:00',
		booking_rueckgabedatum datetime DEFAULT '0000-00-00 00:00:00',
		booking_preis int NOT NULL,
		bike_id mediumint(9) NOT NULL,
		PRIMARY KEY  (booking_id),
        FOREIGN KEY  (bike_id) REFERENCES $forgein_table_name(bike_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('booking_db_version', $booking_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function booking_install_data()
{
	global $wpdb;

	$bookings = Booking::getAllBookingsFromJson();
	$table_name = $wpdb->prefix . 'booking';

	foreach ($bookings as $booking) {
		$booking_abholdatum = $booking->getAbholdatum();
		$booking_rueckgabedatum = $booking->getRueckgabedatum();
		$bike_id = $booking->getBikeId();
		$bike_tagesPreis = Bike::getBikePriceById($bike_id);
		$booking_preis = $booking->calculateBookingPrice($bike_tagesPreis);

		//Achtung Reihnfolge muss beim einfügen in Datenbank richtig sein!
		$wpdb->insert(
			$table_name,
			array(
				'booking_abholdatum' => $booking_abholdatum,
				'booking_rueckgabedatum' => $booking_rueckgabedatum,
				'booking_preis' => $booking_preis,
				'bike_id' => $bike_id
			)
		);
	}
}

//register_activation_hook(MY_PLUGIN_FILE, 'booking_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
//register_activation_hook(MY_PLUGIN_FILE, 'booking_install_data'); //Daten werden in die Datenbank eingefügt