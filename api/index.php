<?php

// Include the Amazon S3 SDK and Slim REST API Framework
use Slim\Middleware\ContentTypes;
use Slim\Slim;

require 'vendor/autoload.php';

// Include the config file with Database credentials
require_once __DIR__ . '/config.php';

// Open the MySQL Connection using PDO
// PDO is a robust method to access Databases and provides built in security to protect from MySQL injections
try {

    // Connect to the database using the Constants defined in config.php
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);

    // This displays any SQL Query syntax errors
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print 'MySQL PDO Connection Error: ' . $e->getMessage();
    die();
}


// This is part of the required code to use the Slim Framework
// Create the Slim app
Slim::registerAutoloader();
$app = new Slim();
$app->add(new ContentTypes());

// Allow cross domain calls via javascript
$app->response()->header('Access-Control-Allow-Origin', '*');
$app->response()->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

$app->get(
    '/',
    function () use ($app, $db) {
        // Return the JSON Data
        $response = $app->response();
        $response->status(200);
        $response->write("The API is working!");
    }
);

// GET LIST OF ALL USERS
$app->get(
    '/users',
    function () use ($app, $db) {

        // Create a return array for the user data
        $userData = array();

        try {

            // Get the information for all users from the database
            $sth = $db->prepare('SELECT * FROM users');
            $sth->execute();
            $userData = $sth->fetchAll(PDO::FETCH_ASSOC);

            // Remove password from returned data
            foreach ($userData as &$user) {
                unset($user['password']);
            }

        } catch(PDOException $e) {
            // SQL ERROR
        }

        // Return the JSON Data
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->status(200);
        $response->write(json_encode($userData));
    }
);


// Run the Slim app as specified by the Slim Framework documentation
$app->run();
