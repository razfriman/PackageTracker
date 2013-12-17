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

$app->get(
    '/packages',
    function () use ($app, $db) {

        $packageData = array();

        try {

            $sth = $db->prepare('SELECT * FROM packages');
            $sth->execute();
            $packageData = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            // SQL ERROR
        }

        // Return the JSON Data
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->status(200);
        $response->write(json_encode($packageData));
    }
);

$app->post(
    '/packages',
    function () use ($app, $db) {

        $request = $app->request()->getBody();

        // Load the request properties
        $product_name = $request['product_name'];
        $status = $request['status'];
        $tracking_number = $request['tracking_number'];
        $estimated_arrival_date = $request['estimated_arrival_date'];
        $order_date = $request['order_date'];
        $link = $request['link'];
        $price = $request['price'];

        $success = false;
        $reason = '';
        $insert_id = -1;

        try {

            // INSERT THE ANSWER
            $sth = $db->prepare('INSERT INTO packages (product_name,status,tracking_number,estimated_arrival_date,order_date,link,price)
					VALUES (:product_name,:status,:tracking_number,:estimated_arrival_date,:order_date,:link,:price)');

            $sth->bindParam(':product_name', $product_name);
            $sth->bindParam(':status', $status);
            $sth->bindParam(':tracking_number', $tracking_number);
            $sth->bindParam(':estimated_arrival_date', $estimated_arrival_date);
            $sth->bindParam(':order_date', $order_date);
            $sth->bindParam(':link', $link);
            $sth->bindParam(':price', $price);
            $sth->execute();

            // Get the new id
            $insert_id = $db->lastInsertId();

            $success = true;

        } catch(PDOException $e) {
            $success = false;
            $reason = $e->getMessage();
            //$reason = 'Error: could not add package';
        }

        // Create the response data
        $dataArray = array(
            'success' => $success,
            'reason' => $reason,
            'insert_id' => $insert_id);

        // Send the JSON response data
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->status(200);
        $response->write(json_encode($dataArray));
    }
);

$app->put(
    '/packages/:id',
    function ($id) use ($app, $db) {

        $request = $app->request()->getBody();

        // Load the request properties
        $product_name = $request['product_name'];
        $status = $request['status'];
        $tracking_number = $request['tracking_number'];
        $estimated_arrival_date = $request['estimated_arrival_date'];
        $order_date = $request['order_date'];
        $link = $request['link'];
        $price = $request['price'];

        $success = false;
        $reason = '';

        try {

            // INSERT THE ANSWER
            $sth = $db->prepare('UPDATE packages SET product_name=:product_name, status=:status, tracking_number=:tracking_number, estimated_arrival_date=:estimated_arrival_date, order_date=:order_date,link=:link,price=:price WHERE id=:id');
            $sth->bindParam(':id', $id);
            $sth->bindParam(':product_name', $product_name);
            $sth->bindParam(':status', $status);
            $sth->bindParam(':tracking_number', $tracking_number);
            $sth->bindParam(':estimated_arrival_date', $estimated_arrival_date);
            $sth->bindParam(':order_date', $order_date);
            $sth->bindParam(':link', $link);
            $sth->bindParam(':price', $price);
            $sth->execute();

            $success = true;

        } catch(PDOException $e) {
            $success = false;
            $reason = $e->getMessage();
        }

        // Create the response data
        $dataArray = array(
            'success' => $success,
            'reason' => $reason);

        // Send the JSON response data
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->status(200);
        $response->write(json_encode($dataArray));
    }
);

$app->delete(
    '/packages/:id',
    function ($id) use ($app, $db) {

        $success = false;
        $reason = '';

        try {

            $sth = $db->prepare('DELETE FROM packages WHERE id=:id');
            $sth->bindParam(':id',$id);
            $sth->execute();

            $success = true;

        } catch(PDOException $e) {
            $success = false;
            $reason = $e->getMessage();
        }

        $dataArray = array(
            'success' => $success,
            'reason' => $reason);

        // Return the JSON Data
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->status(200);
        $response->write(json_encode($dataArray));
    }
);

// Run the Slim app as specified by the Slim Framework documentation
$app->run();
