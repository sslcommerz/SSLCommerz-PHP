=== Plugin Name ===
Contributors: C.M.Sayedur Rahman
	      cmsayed@gmail.com
Tags: Payment Gateway, SSLCommerz, IPN, Raw PHP
Requires : PHP 5.6 and Mysql
License: GPLv2 or later

== Description ==
In this example you will find below script and a mysql table creation file.
  1. index.php : Receive Transaction Data
  2. payment.php: Prepare data and Initate the Transaction
  3. success.php: After successfull payment this page will update database
  4. ipn.php : After successfull  payment this page will update database(If IPN Enaled from Merchant Panel. Gateway will first hit IPN page) 
  5. cancel.php :After cancelling payment this page will update database
  6. fail.php :After failing payment this page will update database
  7. SSLCommerz.php : Libary page
  8. SSLCZConfig.php : Store configuration page. Here you will input store_id, store_password and Gateway link(Live or Sandbox)
  9. connection.php : Database configuration. 
  10.orders.sql : Sample table 

==Run the project==
	1. First create your Sanbox store account from below url. After registration you will get two mail. One for Store_id and Store_password.
	   Another one for Report panel access.	
	   https://developer.sslcommerz.com/registration/
	2. Then give the store_id and store_password in SSLCZConfig.php page. 
	3. Then Create the table(orders.sql) in your database and update the creadential in connection.php
	4. Then run the index.php script from your webserver.It should go to payment gateway.

== Help URL==
	1. https://developer.sslcommerz.com/docs.html :URL to start integrate SSLCOMMERZ as a Developer
	2. https://developer.sslcommerz.com/registration/: URL to Create Account in Sandbox

