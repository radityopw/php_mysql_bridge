<?php

$client = new SoapClient(null, array('location' => "http://localhost/php_mysql_bridge/index.php",
                                     'uri'      => "http://php_mysql_bridge/",
                                     'trace' => 1));

$sql = "INSERT INTO testing(nama,nama2) values ('testing','testing1')";



$client->run_query('learn_fb',  base64_encode($sql));

/*
echo "Response:<br />" . $client->__getLastResponse() . "<br />";

echo "RESPONSE HEADERS:<br />" . $client->__getLastResponseHeaders() . "<br />";

echo "REQUEST:<br />" . $client->__getLastRequest() . "<br />";

echo "REQUEST HEADERS:<br />" . $client->__getLastRequestHeaders() . "<br />";
 * 
 */


$sql2 = "SELECT * FROM testing";

$data = $client->run_query('learn_fb', base64_encode($sql2));

/*

echo "Response:<br />" . $client->__getLastResponse() . "<br />";

echo "RESPONSE HEADERS:<br />" . $client->__getLastResponseHeaders() . "<br />";

echo "REQUEST:<br />" . $client->__getLastRequest() . "<br />";

echo "REQUEST HEADERS:<br />" . $client->__getLastRequestHeaders() . "<br />";
 * 
 */

var_dump($data);


$sql = "DELETE FROM testing";

$client->run_query('learn_fb',  base64_encode($sql));

/*

echo "Response:<br />" . $client->__getLastResponse() . "<br />";

echo "RESPONSE HEADERS:<br />" . $client->__getLastResponseHeaders() . "<br />";

echo "REQUEST:<br />" . $client->__getLastRequest() . "<br />";

echo "REQUEST HEADERS:<br />" . $client->__getLastRequestHeaders() . "<br />";


var_dump($client->test());

echo "Response:<br />" . $client->__getLastResponse() . "<br />";

echo "RESPONSE HEADERS:<br />" . $client->__getLastResponseHeaders() . "<br />";

echo "REQUEST:<br />" . $client->__getLastRequest() . "<br />";

echo "REQUEST HEADERS:<br />" . $client->__getLastRequestHeaders() . "<br />";
 * 
 */