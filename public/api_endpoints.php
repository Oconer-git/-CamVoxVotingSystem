<?php
// CamVox Choice Voting System

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';

$app = new \Slim\App;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "camvoxdb";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$app->post('/login', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    if (isset($data['id']) && isset($data['pass'])) {
        $user_id = $data['id'];
        $user_pass = (string) $data['pass'];

        $stmt = $pdo->prepare("SELECT id, pass, fullname FROM tbstuds WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user_pass === $user['pass']) {
                $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Login successful. Welcome ' . $user['fullname']]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode([
                    'status' => 'error',
                    'message' => 'Invalid password',
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'User not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    } else {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Missing credentials']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

$app->post('/insert_candidate', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    if (
        isset($data['name']) && isset($data['posName']) && isset($data['partyName']) && isset($data['electioncode'])
    ) {
        $name = $data['name'];
        $posName = $data['posName'];
        $partyName = $data['partyName'];
        $electioncode = $data['electioncode'];

        $stmt = $pdo->prepare("INSERT INTO tbcandidate (name, posName, partyName, electioncode) VALUES (:name, :posName, :partyName, :electioncode)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':posName', $posName);
        $stmt->bindParam(':partyName', $partyName);
        $stmt->bindParam(':electioncode', $electioncode);

        if ($stmt->execute()) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Candidate data inserted successfully']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error inserting candidate data']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    } else {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Missing candidate data']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

$app->run();
