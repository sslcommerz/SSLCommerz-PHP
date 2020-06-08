### SSLCommerz Payment Gateway Integration - PHP Library


### Library Directory

```
 |-- config/
    |-- config.php
 |-- lib/
    |-- AbstractSslCommerz.php (core file)
    |-- SslCommerzInterface.php (core file)
    |-- SslCommerzNotification.php (core file)
 |-- pg_redirection/
    |-- cancel.php
    |-- fail.php
    |-- success.php
    |-- ipn.php
 |-- README.md
 |-- orders.sql
 |-- db_connection.php
 |-- checkout_hosted.php
 |-- checkout_ajax.php
 |-- example_easycheckout.php
 |-- example_hosted.php
 |-- OrderTransaction.php
```
#### Instructions:

* __Step 1:__ Download and extract the library files into your project

* __Step 2:__ Create a database and import the `orders.sql` table schema. Then set the database credential on `db_connection.php` file.

* __Step 3:__ For Hosted Checkout integration, you can update the `checkout_hosted.php` or use a different file according to your need. We have provided a basic sample page from where you can kickstart the payment gateway integration.

* __Step 4:__ For EasyCheckout (Popup) integration, you can update the `checkout_ajax.php` or use a different file according to your need. We have provided a basic sample page from where you can kickstart the SSLCommerz payment gateway integration with EasyCheckout (Popup).

* __Step 5:__ Use the below button where you want to show the **"Pay Now"** button (change the values as needed):
```
<button class="your-button-class" id="sslczPayBtn"
        token="if you have any token validation"
        postdata="your javascript arrays or objects which requires in backend"
        order="If you already have the transaction generated for current order"
        endpoint="checkout_ajax.php"> Pay Now
</button>

```

* __Step 6:__ Use the below script before the end of body tag.

##### For Sandbox
```
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

```
##### For Live
```
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

```


* __Step 7:__ For redirecting action from SSLCommerz Payment gateway, we have also provided sample `success.php`, `cancel.php`, `fail.php` and `ipn.php` files. You can update those files according to your need.

### Contributors

>Prabal Mallick

> Md. Rakibul Islam

> integration@sslcommerz.com