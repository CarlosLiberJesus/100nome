<?php
/*
 * config.inc.php
 *
 * Geração Consciente
 * Copyright (c) 2004 PayPal Inc
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */

//Configuration Settings

$paypal['business']="pagamentos@geracaoconsciente.pt";

$paypal['site_url']=$_POST['site_url'];
$paypal['image_url']=$_POST['image_url'];
$paypal['success_url']=$_POST['success_url'];
$paypal['cancel_url']=$_POST['cancel_url'];
$paypal['notify_url']="paypal/ipn/ipn.php";

$paypal['return_method']="2"; //1=GET 2=POST
$paypal['currency_code']="EUR"; //['USD,GBP,JPY,CAD,EUR']
$paypal['lc']="PT";
$paypal['bn']="toolkit-php";
$paypal['cmd']="_cart";

//$paypal['url']="https://www.paypal.com/cgi-bin/webscr";
$paypal['paypal_url']=$_POST['paypal_url'];
$paypal['post_method']="fso"; //fso=fsockopen(); curl=curl command line libCurl=php compiled with libCurl support
$paypal['curl_location']="/usr/local/bin/curl";

//Payment Page Settings
$paypal['display_comment']="0"; //0=yes 1=no
$paypal['comment_header']="Comments";
$paypal['continue_button_text']="Continue >>";
$paypal['background_color']=""; //""=white 1=black
$paypal['display_shipping_address']=""; //""=yes 1=no
$paypal['display_comment']="1"; //""=yes 1=no


//Product Settings
$paypal['num_cart_items']=$_POST['num_cart_items'];
for($i=1;$i<=$_POST['num_cart_items'];$i++){
    $paypal['item_name'.$i]=$_POST['item_name'.$i];
    $paypal['item_number'.$i]=$_POST['item_number'.$i];
    $paypal['amount'.$i]=$_POST['amount'.$i];
    $paypal['quantity'.$i]=$_POST['quantity'.$i];
    $paypal['edit_quantity'.$i]=""; //1=yes ""=no
    $paypal['invoice'.$i]=$_POST['invoice'.$i];
    $paypal['tax'.$i]=$_POST['tax'.$i];
}

//Shipping and Taxes
$paypal['shipping_amount']=$_POST['shipping_amount'];
$paypal['shipping_amount_per_item']="";
$paypal['handling_amount']="";
$paypal['custom_field']=$_POST['custom_field'];
$paypal['custom']=$_POST['custom'];

//Customer Settings
$paypal['firstname']=$_POST['firstname'];
$paypal['lastname']=$_POST['lastname'];
$paypal['address1']=$_POST['address1'];
$paypal['address2']=$_POST['address2'];
$paypal['city']=$_POST['city'];
$paypal['state']=$_POST['state'];
$paypal['zip']=$_POST['zip'];
$paypal['email']=$_POST['email'];
$paypal['phone_1']=$_POST['phone1'];
$paypal['phone_2']=$_POST['phone2'];
$paypal['phone_3']=$_POST['phone3'];

?>