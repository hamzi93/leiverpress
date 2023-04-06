<?php

global $customers_db_version;
$customers_db_version = '1.0';

require_once(MY_PLUGIN_PATH . 'lp-models/class-customer.php');

/**
 * Datenbank erstellen
 */
function customers_install()
{
	global $wpdb;
	global $customers_db_version;

	$table_name = $wpdb->prefix . 'customers';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		customer_id bigint NOT NULL AUTO_INCREMENT,
        customer_firstname varchar(50) NOT NULL,
        customer_lastname varchar(50) NOT NULL,
        customer_email varchar(55) NOT NULL,
        customer_phonenumber varchar(55) NOT NULL,
		PRIMARY KEY  (customer_id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

	add_option('customers_db_version', $customers_db_version);
}

/**
 * Daten mithilfe der Bike Klasse und dem json Format ausgelesen und in Datenbank eingefügt
 */
function customers_install_data()
{
	global $wpdb;

	$customers = Customer::getAllCustomerFromJson();
	$table_name = $wpdb->prefix . 'customers';

	foreach ($customers as $customer) {
        $customerFirstName = $customer->getFirstName();
        $customerLastName = $customer->getLastName();
        $customerEmail = $customer->getEmail();
        $customerPhoneNumber = $customer->getPhoneNumber();
		$wpdb->insert(
			$table_name,
			array(
				'customer_firstname' => $customerFirstName,
                'customer_lastname' => $customerLastName,
                'customer_email' => $customerEmail,
                'customer_phonenumber' => $customerPhoneNumber
			)
		);
	}
}


register_activation_hook(MY_PLUGIN_FILE, 'customers_install'); //Datenbank wird erstellt bei Aktivierung vom Plugin
register_activation_hook(MY_PLUGIN_FILE, 'customers_install_data'); //Daten werden in die Datenbank eingefügt