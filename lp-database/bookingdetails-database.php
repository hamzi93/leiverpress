<?php

global $bookingdetails_db_version;
$bookingdetails_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-bookingdetail.php');

/**
 * Datenbank erstellen
 */
function bookingdetails_install()
{
	global $wpdb;
	global $bookingdetails_db_version;

	$table_name = $wpdb->prefix . 'bookingdetails';
	$forgein_table_bikes = $wpdb->prefix . 'bikes';
    $forgein_table_customers = $wpdb->prefix . 'customers';
	$forgein_table_bookings = $wpdb->prefix . 'bookings';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		bookingdetail_id bigint NOT NULL AUTO_INCREMENT,
        bookingdetail_begindate datetime DEFAULT '0000-00-00 00:00:00',
		bookingdetail_enddate datetime DEFAULT '0000-00-00 00:00:00',
		bookingdetail_price int,
		bike_id mediumint(9) NOT NULL,
		customer_id bigint,
		booking_id bigint NOT NULL,
		PRIMARY KEY  (bookingdetail_id),
		FOREIGN KEY  (bike_id) REFERENCES $forgein_table_bikes(bike_id),
        FOREIGN KEY  (customer_id) REFERENCES $forgein_table_customers(customer_id),
		FOREIGN KEY  (booking_id) REFERENCES $forgein_table_bookings(booking_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('bookingdetails_db_version', $bookingdetails_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function bookingdetails_install_data()
{
	global $wpdb;

	$bookingDetails = BookingDetail::getAllBookingDetailsFromJson();
	$table_name = $wpdb->prefix . 'bookingdetails';

	foreach ($bookingDetails as $bookingDetail) {
		$bookingDetailBeginDate = $bookingDetail->getBeginDate();
		$bookingDetailEndDate = $bookingDetail->getEndDate();
		$bookingDetailPrice = $bookingDetail->getPrice();
		$bikeId = $bookingDetail->getBId();
		$customerId = $bookingDetail->getCuId();
		$bookingId = $bookingDetail->getBkId();

		//Achtung Reihnfolge muss beim einfügen in Datenbank richtig sein!
		$wpdb->insert(
			$table_name,
			array(
				'bookingdetail_begindate' => $bookingDetailBeginDate,
				'bookingdetail_enddate' => $bookingDetailEndDate,
				'bookingdetail_price' => $bookingDetailPrice,
				'bike_id' => $bikeId,
				'customer_id' => $customerId,
				'booking_id' => $bookingId
			)
		);
	}
}

register_activation_hook(MY_PLUGIN_FILE, 'bookingdetails_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'bookingdetails_install_data'); //Daten werden in die Datenbank eingefügt