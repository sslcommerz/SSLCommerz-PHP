<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

# This is a sample page to understand how to connect payment gateway

require_once(__DIR__ . "/lib/SslCommerzNotification.php");

include("db_connection.php");
include("OrderTransaction.php");

use SslCommerz\SslCommerzNotification;

# Organize the submitted/inputted data
$post_data = array();

$post_data['total_amount'] = $_POST['amount'];
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();

# CUSTOMER INFORMATION
$post_data['cus_name'] = isset($_POST['customer_name']) ? $_POST['customer_name'] : "John Doe";
$post_data['cus_email'] = isset($_POST['customer_email']) ? $_POST['customer_email'] : "john.doe@email.com";
$post_data['cus_add1'] = "Dhaka";
$post_data['cus_add2'] = "Dhaka";
$post_data['cus_city'] = "Dhaka";
$post_data['cus_state'] = "Dhaka";
$post_data['cus_postcode'] = "1000";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = isset($_POST['customer_mobile']) ? $_POST['customer_mobile'] : "01711111111";
$post_data['cus_fax'] = "01711111111";

# SHIPMENT INFORMATION
$post_data["shipping_method"] = "YES";
$post_data['ship_name'] = "Store Test";
$post_data['ship_add1'] = "Dhaka";
$post_data['ship_add2'] = "Dhaka";
$post_data['ship_city'] = "Dhaka";
$post_data['ship_state'] = "Dhaka";
$post_data['ship_postcode'] = "1000";
$post_data['ship_phone'] = "";
$post_data['ship_country'] = "Bangladesh";

$post_data['emi_option'] = "1";
$post_data["product_category"] = "Electronic";
$post_data["product_profile"] = "general";
$post_data["product_name"] = "Computer";
$post_data["num_of_item"] = "1";

# OPTIONAL PARAMETERS
// $post_data['value_a'] = "Regent Air";
// $post_data['value_b'] = "ref002";
// $post_data['value_c'] = "ref003";
// $post_data['value_d'] = "ref004";

# MANAGED TRANS
//$post_data['multi_card_name'] = "brac_visa,dbbl_visa,city_visa,ebl_visa,brac_master,dbbl_master,city_master,ebl_master,city_amex,qcash,dbbl_nexus,bankasia,abbank,ibbl,mtbl,city";
//$post_data['allowed_bin'] = "371598,371599,376947,376948,376949";
//$post_data['multi_card_name'] = "bankasia,mtbl,city";


# CART PARAMETERS
// $post_data['cart'] = json_encode(array(
//     array("sku" => "REF0001", "product" => "DHK TO BRS AC A1", "quantity" => "1", "amount" => "200.00"),
//     array("sku" => "REF0002", "product" => "DHK TO BRS AC A2", "quantity" => "1", "amount" => "200.00"),
//     array("sku" => "REF0003", "product" => "DHK TO BRS AC A3", "quantity" => "1", "amount" => "200.00"),
//     array("sku" => "REF0004", "product" => "DHK TO BRS AC A4", "quantity" => "2", "amount" => "200.00")
// ));

//$post_data['emi_max_inst_option'] = "9";
//$post_data['emi_selected_inst'] = "24";


//$post_data['product_amount'] = "0";
//$post_data['discount_amount'] = "5";
/*
$post_data['product_amount'] = "100";
$post_data['vat'] = "5";
$post_data['discount_amount'] = "5";
$post_data['convenience_fee'] = "3";
*/
//$post_data['discount_amount'] = "5";

//$post_data['multi_card_name'] = "brac_visa,brac_master";
//$post_data['allowed_bin'] = "408860,458763,489035,432147,432145,548895,545610,545538,432149,484096,484097,464573,539932,436475";

# RECURRING DATA
// $schedule = array(
//     "refer" => "5B90BA91AA3F2", # Subscriber id which generated in Merchant Admin panel
//     "acct_no" => "01730671731",
//     "type" => "daily", # Recurring Schedule - monthly,weekly,daily
//     //"dayofmonth"	=>	"24", 	# 1st day of every month
//     //"month"		=>	"8",	# 1st day of January for Yearly Recurring
//     //"week"	=>	"sat",	# In case, weekly recurring

// );


// $post_data["product_shipping_contry"] = "Bangladesh";
// $post_data["vip_customer"] = "YES";
// $post_data["hours_till_departure"] = "12 hrs";
// $post_data["flight_type"] = "Oneway";
// $post_data["journey_from_to"] = "DAC-CGP";
// $post_data["third_party_booking"] = "No";

// $post_data["hotel_name"] = "Sheraton";
// $post_data["length_of_stay"] = "2 days";
// $post_data["check_in_time"] = "24 hrs";
// $post_data["hotel_city"] = "Dhaka";


// $post_data["product_type"] = "Prepaid";
// $post_data["phone_number"] = "01711111111";
// $post_data["country_topUp"] = "Bangladesh";

// $post_data["shipToFirstName"] = "John";
// $post_data["shipToLastName"] = "Doe";
// $post_data["shipToStreet"] = "93 B, New Eskaton Road";
// $post_data["shipToCity"] = "Dhaka";
// $post_data["shipToState"] = "Dhaka";
// $post_data["shipToPostalCode"] = "1000";
// $post_data["shipToCountry"] = "Bangladesh";
// $post_data["shipToEmail"] = "john.doe@email.com";
// $post_data["ship_to_phone_number"] = "01711111111";

# SPECIAL PARAM
// $post_data['tokenize_id'] = "1";

# 1 : Physical Goods
# 2 : Non-Physical Goods Vertical(software)
# 3 : Airline Vertical Profile
# 4 : Travel Vertical Profile
# 5 : Telecom Vertical Profile

// $post_data["product_profile_id"] = "5";

// $post_data["topup_number"] = "01711111111"; # topUpNumber

# First, save the input data into local database table `orders`
$query = new OrderTransaction();
$sql = $query->saveTransactionQuery($post_data);

if ($conn_integration->query($sql) === TRUE) {

    # Call the Payment Gateway Library
    $sslcz = new SslCommerzNotification();
    $msg = $sslcz->makePayment($post_data, 'hosted');
    if (!is_array($msg)) {
        echo $msg;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn_integration->error;
}

