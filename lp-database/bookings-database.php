<?php

global $bookings_db_version;
$bookings_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-booking.php');

/**
 * Datenbank erstellen
 */
function bookings_install()
{
	global $wpdb;
	global $bookings_db_version;

	$table_name = $wpdb->prefix . 'bookings';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		booking_id bigint NOT NULL AUTO_INCREMENT,
        booking_date datetime DEFAULT '0000-00-00 00:00:00',
		booking_confirmed BOOLEAN NOT NULL,
		booking_totalprice int,
		PRIMARY KEY  (booking_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bookings_db_version', $bookings_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bookings_install_data()
{
	global $wpdb;

	$bookings = Booking::getAllBookingsFromJson();
	$table_name = $wpdb->prefix . 'bookings';

	foreach ($bookings as $booking) {
		$bookingDate = $booking->getDate();
		$bookingConfirmed = $booking->getConfirmed();
		$bookingTotalPrice = $booking->getTotalPrice();

		//Achtung Reihnfolge muss beim einfügen in Datenbank richtig sein!
		$wpdb->insert(
			$table_name,
			array(
				'booking_date' => $bookingDate,
				'booking_confirmed' => $bookingConfirmed,
				'booking_totalprice' => $bookingTotalPrice
			)
		);
	}
}

register_activation_hook(MY_PLUGIN_FILE, 'bookings_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'bookings_install_data'); //Daten werden in die Datenbank eingefügt