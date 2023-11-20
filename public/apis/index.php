<?php
// CamVox Choice Voting System

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';

$app = new \Slim\App;

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "camvoxdb";

// Database connection
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$app->post('/login', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    if (isset($data['id']) && isset($data['pass'])) {
        $user_id = $data['id'];
        $user_pass = (string) $data['pass'];

        // Fetch user from the database
        $stmt = $pdo->prepare("SELECT id, pass, fullname FROM tbstuds WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password as a string
            if ($user_pass === $user['pass']) {
                // Password is correct, consider the user as authenticated
                $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Login successful. Welcome ' . $user['fullname']]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                // Password is incorrect
                $response->getBody()->write(json_encode([
                    'status' => 'error',
                    'message' => 'Invalid password',
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        } else {
            // User not found
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'User not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    } else {
        // Missing 'id' or 'password' in the request body
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Missing credentials']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});


$app->run();
