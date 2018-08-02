<!DOCTYPE html>
<title>Payment Page</title>
<h1>SSLCOMMERZ Integration Payment Page</h1>
<style>
    .payOptions {
        overflow: hidden
    }

    .payOptions li {
        list-style-type: none;
        float: left;
    }

    .row-last > * {
        margin-top: 0 !important
    }
</style>
<?php
session_start();
include("connection.php");
include("SSLCommerz.php");
$name = $_POST["cus_name"];
$email = $_POST["cus_email"];
$address = $_POST["cus_address"];
$phone = $_POST["phone_number"];
$transaction_amount = $_POST["total_payable_amount"];
$transaction_id = uniqid();
$currency = 'BDT';

if ($_SERVER['SERVER_NAME'] == "localhost") {
    $server_name = 'http://localhost/integration_raw/';
} else {
    $server_name = 'http://yourdomain.com/integration_raw/';
}

$post_data = array();
$post_data['total_amount'] = $_POST["total_payable_amount"];
$post_data['currency'] = $currency;
$post_data['tran_id'] = $transaction_id;
$post_data['success_url'] = $server_name . "success.php";
$post_data['fail_url'] = $server_name . "fail.php";
$post_data['cancel_url'] = $server_name . "cancel.php";

# CUSTOMER INFORMATION
$post_data['cus_name'] = $_POST["cus_name"];
$post_data['cus_email'] = $_POST["cus_email"];
$post_data['cus_add1'] = $_POST["cus_address"];
$post_data['cus_add2'] = "";
$post_data['cus_city'] = "";
$post_data['cus_state'] = "";
$post_data['cus_postcode'] = "";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = $_POST["phone_number"];
$post_data['cus_fax'] = "";

# SHIPMENT INFORMATION
$post_data['ship_name'] = $_POST["cus_name"];
$post_data['ship_add1 '] = $_POST["cus_address"];
$post_data['ship_add2'] = "";
$post_data['ship_city'] = "";
$post_data['ship_state'] = "";
$post_data['ship_postcode'] = "";
$post_data['ship_country'] = "Bangladesh";

# OPTIONAL PARAMETERS
$post_data['value_a'] = "ref001";
$post_data['value_b'] = "ref002";
$post_data['value_c'] = "ref003";
$post_data['value_d'] = "ref004";


$_SESSION['payment_values'] = array();

$_SESSION['payment_values']['tran_id'] = $post_data['tran_id'];
$_SESSION['payment_values']['amount'] = $post_data['total_amount'];
$_SESSION['payment_values']['currency'] = $post_data['currency'];


$sql = "INSERT INTO orders (name, email, phone, amount, address, status, transaction_id,currency)
VALUES ('$name', '$email', '$phone','$transaction_amount','$address','Pending', '$transaction_id','$currency')";

if ($conn_integration->query($sql) === TRUE) 
{
    echo "Payment Record Inserted";
    $sslc = new SSLCommerz();
    # initiate(Transaction Data , Whether redirect or Display in Page)
    $payment_options = $sslc->initiate($post_data, false);

    if (!is_array($payment_options)) 
    {
        print_r($payment_options);
        $payment_options = array();

        echo '<h3>Card Payment</h3>';
        echo "<ul class='payOptions'>";

        if (array_key_exists("cards", $payment_options) && !empty($payment_options['cards'])) 
        {
            foreach ($payment_options['cards'] as $row) {
                echo '<li>' . $row['link'] . '</li>';
            }
        }
        echo "</ul>";
        echo '<h3>Mobile Payment</h3>';
        echo "<ul class='payOptions'>";
        if (array_key_exists("mobile", $payment_options) && !empty($payment_options['mobile'])) {
            foreach ($payment_options['mobile'] as $row) {
                echo '<li>' . $row['link'] . '</li>';
            }
        }
        echo "</ul>";
        echo '<h3>Internet Banking</h3>';
        echo "<ul class='payOptions'>";
        if (array_key_exists("internet", $payment_options) && !empty($payment_options['internet'])) {
            foreach ($payment_options['internet'] as $row) {
                echo '<li>' . $row['link'] . '</li>';
            }
        }
        echo "</ul>";
        echo '<h3>Other Options</h3>';
        echo "<ul class='payOptions'>";
        if (array_key_exists("others", $payment_options) && !empty($payment_options['others'])) {
            foreach ($payment_options['others'] as $row) {
                echo '<li>' . $row['link'] . '</li>';
            }
        }
        echo "</ul>";
    }
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn_integration->error;
}


?>