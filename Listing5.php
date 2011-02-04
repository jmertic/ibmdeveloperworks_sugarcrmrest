<?php

// specify the REST web service to interact with
$url = 'http://localhost/sugarcrm/service/v2/rest.php';

// Open a curl session for making the call
$curl = curl_init($url);

// Tell curl to use HTTP POST
curl_setopt($curl, CURLOPT_POST, true);

// Tell curl not to return headers, but do return the response
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Set the POST arguments to pass to the Sugar server
$parameters = array(
    'user_auth' => array(
        'user_name' => 'user',
        'password' => md5('password'),
        ),
    );
$json = json_encode($parameters);
$postArgs = array(
    'method' => 'login',
    'input_type' => 'JSON',
    'response_type' => 'JSON',
    'rest_data' => $json,
    );
curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs);

// Make the REST call, returning the result
$response = curl_exec($curl);

// Convert the result from JSON format to a PHP array
$result = json_decode($response);
if ( !is_object($result) ) {
    die("Error handling result.\n");
}
if ( !isset($result->id) ) {
    die("Error: {$result->name} - {$result->description}\n.");
}

// Get the session id
$sessionId = $result->id;

// Now, let's add new Contacts records
$parameters = array(
    'session' => $sessionId,
    'module' => 'Contacts',
    'name_value_lists' => 
        array(
            array('name' => 'first_name', 'value' => 'John'),
            array('name' => 'last_name', 'value' => 'Mertic'),
        ),
        array(
            array('name' => 'first_name', 'value' => 'Dominic'),
            array('name' => 'last_name', 'value' => 'Mertic'),
        ),
        array(
            array('name' => 'first_name', 'value' => 'Mallory'),
            array('name' => 'last_name', 'value' => 'Mertic'),
        ),
    );
$json = json_encode($parameters);
$postArgs = array(
    'method' => 'set_entries',
    'input_type' => 'JSON',
    'response_type' => 'JSON',
    'rest_data' => $json,
    );
curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs);

// Make the REST call, returning the result
$response = curl_exec($curl);

// Convert the result from JSON format to a PHP array
$result = json_decode($response);
if ( !is_object($result) ) {
    die("Error handling result.\n");
}
if ( !isset($result->ids) ) {
    die("Error: {$result->name} - {$result->description}\n.");
}

// Get the newly created record ids as an array
var_dump($result->ids);

