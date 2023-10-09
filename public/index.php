<?php
//CamVox Choice Voting System

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';

$app = new \Slim\App;

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

/*$app->post('/postName', function (Request $request, Response $response, array $args) use ($servername, $username, $password, $dbname) {
    $data = json_decode($request->getBody());
    $fname = $data->fname;
    $lname = $data->lname;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO names (fname, lname) VALUES (:fname, :lname)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->execute();

        $response->getBody()->write(json_encode(array("status" => "success", "data" => $data)));
    } catch (PDOException $e) {
        $response->getBody()->write(json_encode(array("status" => "error", "message" => $e->getMessage())));
    }

    $conn = null;
});

*/

$app->run();
