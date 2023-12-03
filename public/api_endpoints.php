<?php
header("Access-Control-Allow-Origin: *"); // Replace * with your actual domain
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
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


///// Endpoint for Logging In /////
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
            // Verify password as a string
            if ($user_pass === $user['pass']) {
                // Password is correct, consider the user as authenticated
                $response_data = ['status' => 'success', 'data' => ['message' => 'Login successful. Welcome ' . $user['fullname']]];
                $response->getBody()->write(json_encode($response_data));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                // Password is incorrect
                $response_data = ['status' => 'fail', 'data' => ['message' => 'Invalid password']];
                $response->getBody()->write(json_encode($response_data));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        } else {
            // User not found
            $response_data = ['status' => 'fail', 'data' => ['message' => 'User not found']];
            $response->getBody()->write(json_encode($response_data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    // Missing credentials
    $response_data = ['status' => 'error', 'message' => 'Missing credentials'];
    $response->getBody()->write(json_encode($response_data));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
});
/* METHOD: POST
//http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/login
/*Payload:
{
    "id": 19108242,
    "pass": "123"
}

 Response if successful:
{
    "status": "success",
    "data": {
        "message": "Login successful. Welcome Jave Brevin O. Torres"
    }
}

Response if there if invalid password:
{
    "status": "success",
    "data": {
        "message": "Login successful. Welcome Jave Brevin O. Torres"
    }
}

Response if user not found
{
  "status": "fail",
  "data": {
    "message": "User not found"
  }
}

Response if missing credentials
{
  "status": "error",
  "message": "Missing credentials"
}
*/

/////Endpoint for submitting Election info/////--David Justine
$app->post('/createElection', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    if (
        isset($data['electName']) && isset($data['startDate']) && isset($data['endDate']) &&
        isset($data['expTime']) && isset($data['startTime']) && isset($data['description']) &&
        isset($data['posterID']) && isset($data['college']) && isset($data['pendingPostBool'])
    ) {
        $electName = $data['electName'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $expTime = $data['expTime'];
        $startTime = $data['startTime'];
        $description = $data['description'];
        $posterID = $data['posterID'];
        $college = $data['college'];
        $pendingPostBool = $data['pendingPostBool'] ? 1 : 0; // Convert boolean to integer

        $stmt = $pdo->prepare("INSERT INTO tbelect (electName, startDate, endDate, expTime, startTime, description, posterID, college, pendingPostBool) 
            VALUES (:electName, :startDate, :endDate, :expTime, :startTime, :description, :posterID, :college, :pendingPostBool)");
        $stmt->bindParam(':electName', $electName);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->bindParam(':expTime', $expTime);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':posterID', $posterID);
        $stmt->bindParam(':college', $college);
        $stmt->bindParam(':pendingPostBool', $pendingPostBool, PDO::PARAM_INT); // Specify PDO::PARAM_INT

        if ($stmt->execute()) {
            // Success response in JSEND format
            $response->getBody()->write(json_encode(['status' => 'success', 'data' => ['message' => 'Election added successfully']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            // Error response in JSEND format
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error adding election']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    } else {
        // Fail response in JSEND format
        $response->getBody()->write(json_encode(['status' => 'fail', 'data' => ['message' => 'Missing election data']]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/createElection

Payload:
{
  "electName": "Sample Election",
  "startDate": "2023-01-01",
  "endDate": "2023-01-15",
  "expTime": "15:00:00",
  "startTime": "09:00:00",
  "description": "This is a sample election.",
  "posterID": 123,
  "college": "Sample College",
  "pendingPostBool": false
}

Response if successful:
{
    "status": "success",
    "data": {
        "message": "Election added successfully"
    }
}

Response if missing database error:
{
  "status": "error",
  "message": "Error adding election"
}

Response if missing election data:
{
  "status": "fail",
  "data": {
    "message": "Missing election data"
  }
}
*/

///// Endpoint for Adding Positions in the submission of election form/////--David Justine 
$app->post('/addPosition', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if positions array is provided
    if (isset($data['positions']) && is_array($data['positions'])) {
        $positions = $data['positions'];
        
        // Check if required fields are provided for each position
        foreach ($positions as $position) {
            if (!isset($position['positionName']) || !isset($position['electionCode'])) {
                $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Missing position data']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        }

        // Add each position to the database
        foreach ($positions as $position) {
            $positionName = $position['positionName'];
            $electionCode = $position['electionCode'];

            $stmt = $pdo->prepare("INSERT INTO tbpositions (positionName, electionCode) VALUES (:positionName, :electionCode)");
            $stmt->bindParam(':positionName', $positionName);
            $stmt->bindParam(':electionCode', $electionCode);

            if (!$stmt->execute()) {
                $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error adding position']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        }

        // On successful insertion of all positions
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Positions added successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // If positions array is missing in the request
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Missing positions array']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});
/*METHOD: POST
//http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/addPosition
Payload:
{
    "positions": [
        {"positionName": "President", "electionCode": 5},
        {"positionName": "Vice President", "electionCode": 5},
        {"positionName": "Secretary", "electionCode": 5},
        {"positionName": "Treasurer", "electionCode": 5},
        {"positionName": "PIO", "electionCode": 5}
    ]
}

Response if successful:
{
    "status": "success",
    "message": "Positions added successfully"
}

Response if missing position data
{
    "status": "error",
    "message": "Missing position data"
}

Response if there is error in database
{
    "status": "error",
    "message": "Error adding position"
}


Response if missing position in array
{
    "status": "error",
    "message": "Missing positions array"
}
*/

///// Endpoint for showing positions on submitting election form and voting form*
$app->post('/getPositions', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if the election code is provided
    if (isset($data['electionCode'])) {
        $electionCode = $data['electionCode'];

        // Retrieve positions for the specified election code
        $stmt = $pdo->prepare("SELECT positionID, positionName, electionCode FROM tbpositions WHERE electionCode = :electionCode");
        $stmt->bindParam(':electionCode', $electionCode);
        $stmt->execute();
        $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if positions were found
        if ($positions) {
            $responsePayload = [
                'status' => 'success',
                'data' => $positions
            ];
            return $response->withJson($responsePayload, 200);
        } else {
            $responsePayload = [
                'status' => 'fail',
                'data' => ['message' => 'No positions found for the specified election code']
            ];
            return $response->withJson($responsePayload, 404);
        }
    } else {
        // If election code is missing in the request
        $responsePayload = [
            'status' => 'fail',
            'data' => ['message' => 'Missing election code']
        ];
        return $response->withJson($responsePayload, 400);
    }
});
/*

http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/getPositions
Payload:
{
  "electionCode": 4321 
}

Response if successful:
{
    "status": "success",
    "data": [
        {
            "positionID": "1",
            "positionName": "Mayor",
            "electionCode": "4321"
        },
        {
            "positionID": "2",
            "positionName": "Mayor",
            "electionCode": "4321"
        }
    ]
}


Response if there is error
{
    "status": "error",
    "message": "Error adding position"
}

Response if missing position data
{
    "status": "error",
    "message": "Missing position data"
}
*/

///// Endpoint for Adding Candidate on created positions /////
$app->post('/insert_candidates', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if data is provided
    if (isset($data['candidates']) && is_array($data['candidates'])) {
        $candidates = $data['candidates'];
        $successCount = 0;

        // Iterate through each candidate data
        foreach ($candidates as $candidate) {
            // Check if all required fields are provided
            if (
                isset($candidate['candidateName']) && isset($candidate['posID']) &&
                isset($candidate['partyName']) && isset($candidate['electionCode']) &&
                isset($candidate['votesNum'])
            ) {
                $candidateName = $candidate['candidateName'];
                $posID = $candidate['posID'];
                $partyName = $candidate['partyName'];
                $electioncode = $candidate['electionCode'];
                $votesNum = $candidate['votesNum'];

                // Insert data into tbcandidate table
                $stmt = $pdo->prepare("INSERT INTO tbcandidate (candidateName, posID, partyName, electionCode, votesNum) 
                    VALUES (:candidateName, :posID, :partyName, :electionCode, :votesNum)");

                $stmt->bindParam(':candidateName', $candidateName);
                $stmt->bindParam(':posID', $posID);
                $stmt->bindParam(':partyName', $partyName);
                $stmt->bindParam(':electionCode', $electioncode);
                $stmt->bindParam(':votesNum', $votesNum);

                // Execute the query
                if ($stmt->execute()) {
                    $successCount++;
                }
            }
        }

        if ($successCount > 0) {
            // Success response in JSEND format
            $response->getBody()->write(json_encode(['status' => 'success', 'data' => ['message' => $successCount . ' candidates added successfully']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            // Error response in JSEND format
            $response->getBody()->write(json_encode(['status' => 'error', 'data' => ['message' => 'Error adding candidates']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    } else {
        // Fail response in JSEND format
        $response->getBody()->write(json_encode(['status' => 'fail', 'data' => ['message' => 'Missing or invalid candidate data']]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});



/*METHOD: POST
//http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/insert_candidates
/*
Payload:
{
  "candidates": [
    {
      "candidateName": "John Doe",
      "posID": 7,
      "partyName": "Example Party",
      "electionCode": 5,
      "votesNum":0
    },
    {
      "candidateName": "Jane Smith",
      "posID": 7,
      "partyName": "Another Party",
      "electionCode": 5,
      "votesNum":0
    },
    {
      "candidateName": "Bob Johnson",
      "posID": 8,
      "partyName": "Sausage Party",
      "electionCode": 5,
      "votesNum":0
    },
    {
      "candidateName": "Bob JMarley",
      "posID": 8,
      "partyName": "Jannah Party",
      "electionCode": 5,
      "votesNum":0
    }
  ]
}

Response if successful:
{
  "status": "success",
  "data": {
    "message": "4 candidates added successfully"
  }
}


Response if there is error
{
  "status": "error",
  "data": {
    "message": "Error adding candidates"
  }
}

Response if missing candidate data
{
  "status": "fail",
  "data": {
    "message": "Missing or invalid candidate data"
  }
}
*/

///Endpoint for displaying candidates in voting form
$app->post('/loadCandidatesInfo', function (Request $request, Response $response, array $args) use ($pdo) {
    // Get the payload (electionCode) from the request
    $data = $request->getParsedBody();
    $electionCode = $data['electionCode'];

    // Prepare the SQL statement
    $sql = "SELECT candidateID, candidateName, posID, partyName FROM tbcandidate WHERE electionCode = :electionCode";

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':electionCode', $electionCode, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are results
    if (!empty($results)) {
        // Return success response in JSend format
        $response_data = array('status' => 'success', 'data' => $results);
    } else {
        // Return error response in JSend format
        $response_data = array('status' => 'fail', 'data' => 'No data found for the specified electionCode');
    }

    // Return the results as JSON
    $response->getBody()->write(json_encode($response_data));
    return $response->withHeader('Content-Type', 'application/json');
});

/*METHOD: POST
//http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/loadCandidatesInfo
/*
Payload:
{
    "electionCode": 5
}

Response if successful:
{
    "status": "success",
    "data": [
        {
            "candidateID": "6",
            "candidateName": "John Doe",
            "posID": "7",
            "partyName": "Example Party"
        },
        {
            "candidateID": "7",
            "candidateName": "Jane Smith",
            "posID": "7",
            "partyName": "Another Party"
        },
        {
            "candidateID": "8",
            "candidateName": "Bob Johnson",
            "posID": "8",
            "partyName": "Sausage Party"
        },
        {
            "candidateID": "9",
            "candidateName": "Bob JMarley",
            "posID": "8",
            "partyName": "Jannah Party"
        }
    ]
}


Response if there is error
{
  "status": "fail",
  "data": "No data found for the specified electionCode"
}

*/


///// Endpoint for Displaying Election Details on election cards*/////
$app->post('/loadElectionInfo', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();
    $collegeName = isset($data['college']) ? $data['college'] : '';

    $stmt = $pdo->prepare("SELECT * FROM tbelect WHERE college = :college AND pendingPostBool = 1");
    $stmt->bindParam(':college', $collegeName);
    $stmt->execute();
    $electionInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($electionInfo) {
        $responseData = [];

        foreach ($electionInfo as $election) {
            $cardData = [
                'electionID' => $election['electionID'],
                'electName' => $election['electName'],
                'startDate' => $election['startDate'],
                'endDate' => $election['endDate'],
                'expTime' => $election['expTime'],
                'startTime' => $election['startTime'],
                'description' => $election['description'],
                'posterID' => $election['posterID'],
                'college' => $election['college'], 
            ];

            $responseData[] = $cardData;
        }

        $response->getBody()->write(json_encode(['status' => 'success', 'data' => $responseData]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'No election information found']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/loadElectionInfo

Payload:
{
  "college": "Sample College"
}

Response if successful:  
{   //only appears when pendingPostBool is set to 1 in tbelect
    "status": "success",
    "data": [
        {
            "electionID": "6",
            "electName": "Sample Election with college and pendingPostBool",
            "startDate": "2023-01-01",
            "endDate": "2023-01-15",
            "expTime": "15:00:00",
            "startTime": "09:00:00",
            "description": "This is a sample election.",
            "posterID": "1",
            "college": "Sample College"
        },
        {
            "electionID": "7",
            "electName": "Sample Election with college and pendingPostBool2",
            "startDate": "2023-01-01",
            "endDate": "2023-01-15",
            "expTime": "15:00:00",
            "startTime": "09:00:00",
            "description": "This is a sample election.",
            "posterID": "2",
            "college": "Sample College"
        }
    ]
}

Response if missing database error:
{
  "status": "error",
  "message": "No election information found"
}
*/

///Endpoint for approving election *admin*
$app->post('/approveElection', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Assuming $data['electionID'] contains the election ID you want to match
    $electionID = $data['electionID'];

    // Update the pendingPostBool in the tbelect table
    $stmt = $pdo->prepare("UPDATE tbelect SET pendingPostBool = true WHERE electionID = :electionID");
    $stmt->bindParam(':electionID', $electionID);

    try {
        $stmt->execute();

        // Check if any rows were affected
        $rowsAffected = $stmt->rowCount();

        if ($rowsAffected > 0) {
            // Success response in JSend format
            $responsePayload = [
                'status' => 'success',
                'data' => [
                    'message' => 'Election approved successfully',
                ],
            ];
        } else {
            // No rows were affected, electionID not found
            $responsePayload = [
                'status' => 'fail',
                'data' => [
                    'message' => 'Election not found or already approved',
                ],
            ];
        }
    } catch (PDOException $e) {
        // Database error
        $responsePayload = [
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage(),
        ];
    }

    // Convert the response payload to JSON
    $response->getBody()->write(json_encode($responsePayload));

    // Set the content type to JSON
    return $response->withHeader('Content-Type', 'application/json');
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/approveElection

Payload:
{
  "electionID": 3
}

Response if successful:
{
    "status": "success",
    "data": {
        "message": "Election approved successfully"
    }
}


Response if election is not found, or it is already approved by the admin:
{
    "status": "fail",
    "data": {
        "message": "Election not found or already approved"
    }
}

Response if there is error response:
{
    "status": "error",
    "message": "Database error: [error_message]"
}
*/


///// Endpoint for Displaying Election details in voting form*/////
$app->post('/loadElectionInfoVotingForm', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();
    $electionID = isset($data['electionID']) ? $data['electionID'] : '';

    $stmt = $pdo->prepare("SELECT * FROM tbelect WHERE electionID = :electionID AND pendingPostBool = 1");
    $stmt->bindParam(':electionID', $electionID);
    $stmt->execute();
    $electionInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($electionInfo) {
        $responseData = [];

        foreach ($electionInfo as $election) {
            $cardData = [
                'electionID' => $election['electionID'],
                'electName' => $election['electName'],
                'startDate' => $election['startDate'],
                'endDate' => $election['endDate'],
                'expTime' => $election['expTime'],
                'startTime' => $election['startTime'],
                'description' => $election['description'],
                'posterID' => $election['posterID'],
                'college' => $election['college'],
            ];

            $responseData[] = $cardData;
        }

        $response->getBody()->write(json_encode(['status' => 'success', 'data' => $responseData]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'No election information found']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/loadElectionInfoVotingForm

Payload:
{
  "electionID": 6
}

Response if successful:
{
    "status": "success",
    "data": [
        {
            "electionID": "6",
            "electName": "Sample Election with college and pendingPostBool",
            "startDate": "2023-01-01",
            "endDate": "2023-01-15",
            "expTime": "15:00:00",
            "startTime": "09:00:00",
            "description": "This is a sample election.",
            "posterID": "1",
            "college": "Sample College"
        }
    ]
}


Response if no election info is found, might me pendingPostBool is zero:
{
  "status": "error",
  "message": "No election information found",
  "data": null
}

Response if invalid data format:
{
  "status": "fail",
  "message": "Invalid data format",
  "data": null
}
*/


///Endpoint for voting candidates 
$app->post('/voteCandidates', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    if (isset($data['candidates']) && is_array($data['candidates'])) {
        foreach ($data['candidates'] as $candidate) {
            if (isset($candidate['candidateID'])) {
                $candidateID = $candidate['candidateID'];

                // Increment votesNum for the specified candidateID
                $pdo->beginTransaction();
                $stmt = $pdo->prepare("UPDATE tbcandidate SET votesNum = votesNum + 1 WHERE candidateID = :candidateID");
                $stmt->bindParam(':candidateID', $candidateID, PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    $pdo->commit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    $response->getBody()->write("Error updating votesNum for candidateID $candidateID");
                    return $response->withStatus(500);
                }
            }
        }

        $response->getBody()->write("Votes updated successfully");
        return $response->withStatus(200);
    } else {
        $response->getBody()->write("Invalid data format");
        return $response->withStatus(400);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/voteCandidates

Payload:
{
  "candidates": [
    {
      "candidateID": 6
    },
    {
      "candidateID": 8
    }
  ]
}

Response if successful:
{
  "status": "success",
  "message": "Votes updated successfully",
  "data": null
}

Response if invalid payload format:
{
  "status": "fail",
  "message": "Invalid data format",
  "data": null
}

Response if error updating votesNum:
{
  "status": "error",
  "message": "Error updating votesNum for candidateID 6",
  "data": null
}
*/




///Endpoint for sending record that user voted in that election
$app->post('/voterRecord', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Assuming $data['voterID'] and $data['electionCode'] are provided in the request body
    $voterID = $data['voterID'];
    $electionCode = $data['electionCode'];

    // Insert voter record into tbvoters table
    $stmt = $pdo->prepare("INSERT INTO tbvoters (voterID, electionCode) VALUES (:voterID, :electionCode)");
    $stmt->bindParam(':voterID', $voterID);
    $stmt->bindParam(':electionCode', $electionCode);

    try {
        $stmt->execute();

        // Success response in JSend format
        $responsePayload = [
            'status' => 'success',
            'data' => [
                'message' => 'Voter record successfully recorded',
            ],
        ];
    } catch (PDOException $e) {
        // Database error
        $responsePayload = [
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage(),
        ];
    }

    // Convert the response payload to JSON
    $response->getBody()->write(json_encode($responsePayload));

    // Set the content type to JSON
    return $response->withHeader('Content-Type', 'application/json');
});
/*
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/voterRecord
Payload:
{
    "voterID": 19108242,
    "electionCode": 3
}

Response if successful:
{
    "status": "success",
    "data": {
        "message": "Voter record successfully recorded"
    }
}

Response if there is error:
{
    "status": "error",
    "message": "Database error: [error_message]"
}
*/

///Endpoint for checking if user voted in that particular election
$app->post('/checkIfUserVoted', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if both voterID and electionCode are provided in the request
    if (isset($data['voterID']) && isset($data['electionCode'])) {
        // Sanitize input to prevent SQL injection
        $voterID = intval($data['voterID']);
        $electionCode = intval($data['electionCode']);

        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("SELECT * FROM tbvoters WHERE voterID = :voterID AND electionCode = :electionCode");
        $stmt->bindParam(':voterID', $voterID, PDO::PARAM_INT);
        $stmt->bindParam(':electionCode', $electionCode, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a row was found
        if ($result) {
            // Voter exists for the specified electionCode
            $response->getBody()->write(json_encode(["status" => "success", "data" => $result]));
        } else {
            // Voter not found for the specified electionCode
            $response->getBody()->write(json_encode(["status" => "fail", "data" => null, "message" => "Voter not found for the specified electionCode"]));
        }
    } else {
        // VoterID or electionCode not provided in the request
        $response->getBody()->write(json_encode(["status" => "error", "message" => "VoterID and electionCode must be provided"]));
    }

    return $response;
});
/*
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/checkIfUserVoted
Payload:
{
    "voterID": 19108242,
    "electionCode": 3
}

Response if successful:
{
  "status": "success",
  "data": {
    "voterID": 19108242,
    "electionCode": 3,

  }
}

Response if there is voter did not vote in the election:
{
  "status": "fail",
  "data": null,
  "message": "Voter not found for the specified electionCode"
}

Response if there is error:
{
  "status": "error",
  "message": "VoterID and electionCode must be provided"
}
*/


///Endpoint for showing results of election
$app->post('/electionResults', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if electionCode is provided in the request
    if (isset($data['electionCode'])) {
        // Sanitize input to prevent SQL injection
        $electionCode = intval($data['electionCode']);

        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("SELECT candidateName, posID, partyName, votesNum FROM tbcandidate WHERE electionCode = :electionCode");
        $stmt->bindParam(':electionCode', $electionCode, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any results were found
        if ($results) {
            // Election results found for the specified electionCode
            $response->getBody()->write(json_encode([
                "status" => "success",
                "data" => $results
            ], JSON_PRETTY_PRINT));
        } else {
            // No election results found for the specified electionCode
            $response->getBody()->write(json_encode([
                "status" => "fail",
                "data" => null,
                "message" => "No election results found for the specified electionCode"
            ], JSON_PRETTY_PRINT));
        }
    } else {
        // ElectionCode not provided in the request
        $response->getBody()->write(json_encode([
            "status" => "error",
            "message" => "ElectionCode must be provided"
        ], JSON_PRETTY_PRINT));
    }

    return $response;
});

/*
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/electionResults
Payload:
{
    "electionCode": 5
}

Response if successful:
{
"status": "success",
"data": [
{
"candidateName": "John Doe",
"posID": "7",
"partyName": "Example Party",
"votesNum": "1"
},
{
"candidateName": "Jane Smith",
"posID": "7",
"partyName": "Another Party",
"votesNum": "0"
},
{
"candidateName": "Bob Johnson",
"posID": "8",
"partyName": "Sausage Party",
"votesNum": "1"
},
{
"candidateName": "Bob JMarley",
"posID": "8",
"partyName": "Jannah Party",
"votesNum": "0"
}
]
}

Response if no election found:
{
  "status": "fail",
  "data": null,
  "message": "No election results found for the specified electionCode"
}

Response if electionCod is not provided:
{
  "status": "error",
  "message": "ElectionCode must be provided"
}
*/


///Endpoint for changing password *not working*
$app->post('/changePassword', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if all required parameters are present in the payload
    if (!isset($data['ID']) || !isset($data['current_pass']) || !isset($data['new_pass'])) {
        return $response->withJson(['status' => 'fail', 'message' => 'Missing required parameters']);
    }

    // Fetch the current 'pass' from tbstuds based on the provided ID
    $stmt = $pdo->prepare("SELECT pass FROM tbstuds WHERE ID = :id");
    $stmt->bindParam(':id', $data['ID']);
    $stmt->execute();
    $currentPass = $stmt->fetchColumn();

    // Check if the provided current password matches the one in the database
    if ($data['current_pass'] !== $currentPass) {
        return $response->withJson(['status' => 'fail', 'message' => 'Current password does not match']);
    }

    // Update the 'pass' in tbstuds with the new password
    $stmt = $pdo->prepare("UPDATE tbstuds SET pass = :new_pass WHERE ID = :id");
    $stmt->bindParam(':new_pass', $data['new_pass']);
    $stmt->bindParam(':id', $data['ID']);
    $stmt->execute();

    return $response->withJson(['status' => 'success', 'message' => 'Password updated successfully']);
});


/*
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/changePassword
Payload:
{
    "ID": 19108242,
    "current_pass": "123",  
    "new_pass": "pass"  
}

Response if successful:
{
    "status": "success",
    "message": "Password updated successfully"
}

Response if missing required parameters:
{
    "status": "fail",
    "data": {
        "message": "Missing required parameters"
    }
}

Response if password doesn't match:
{
    "status": "fail",
    "data": {
        "message": "Current password does not match"
    }
}
*/




///// Endpoint for Deleting Election /////
$app->post('/deleteElection', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();
    $electionId = isset($data['electionID']) ? $data['electionID'] : null;

    // Check if the election ID is provided
    if (empty($electionId)) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Election ID is required']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Delete the election from the database
    $stmt = $pdo->prepare("DELETE FROM tbelect WHERE electionID = :election_id");
    $stmt->bindParam(':election_id', $electionId);

    if ($stmt->execute()) {
        // Election deleted successfully
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Election deleted successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // Error deleting election
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error deleting election']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/deleteElection

Payload:
{
  "electionID": 123
}

Response if successful:  
{
  "status": "success",
  "message": "Election deleted successfully"
}

Response if there is error:
{
  "status": "error",
  "message": "Error deleting election"
}

Response if invalid request
{
  "status": "error",
  "message": "Election ID is required"
}

*/


//disregard for now
///// Endpoint for Deleting Positions /////--David Justine
$app->delete('/deletePosition/{positionID}', function (Request $request, Response $response, array $args) use ($pdo) {
    $positionID = $args['positionID'];

    // Prepare SQL statement to delete a position based on positionID
    $stmt = $pdo->prepare("DELETE FROM tbpositions WHERE positionID = :positionID");
    $stmt->bindParam(':positionID', $positionID);

    // Execute the deletion query
    if ($stmt->execute()) {
        // If successful deletion
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Position deleted successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // If deletion encountered an error
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error deleting position']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});




/////////////// FOR ADMIN /////
///// Endpoint for Student Register /////
$app->post('/registerStudent', function (Request $request, Response $response) use ($pdo) {
    // Get the student data from the request body
    $data = $request->getParsedBody();

    // Validate required fields
    if (!isset($data['id']) || !isset($data['email']) || !isset($data['fullname']) || !isset($data['dob']) || !isset($data['gender']) || !isset($data['address']) || !isset($data['course']) || !isset($data['cpnum']) || !isset($data['pass']) || !isset($data['college'])) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Incomplete student information']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Extract student data
    $studentId = $data['id'];
    $email = $data['email'];
    $fullname = $data['fullname'];
    $dob = $data['dob'];
    $gender = $data['gender'];
    $address = $data['address'];
    $course = $data['course'];
    $cpnum = $data['cpnum'];
    $password = $data['pass'];
    $college = $data['college'];

    // Check if the student ID is already registered
    $checkStmt = $pdo->prepare("SELECT * FROM tbstuds WHERE id = :student_id");
    $checkStmt->bindParam(':student_id', $studentId);
    $checkStmt->execute();
    $existingStudent = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingStudent) {
        // Student with the same ID already exists
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student with the provided ID already exists']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
    }

    // Insert new student into the database
    $insertStmt = $pdo->prepare("INSERT INTO tbstuds (id, email, fullname, dob, gender, address, course, cpnum, pass, college) VALUES (:student_id, :email, :fullname, :dob, :gender, :address, :course, :cpnum, :pass, :college)");
    $insertStmt->bindParam(':student_id', $studentId);
    $insertStmt->bindParam(':email', $email);
    $insertStmt->bindParam(':fullname', $fullname);
    $insertStmt->bindParam(':dob', $dob);
    $insertStmt->bindParam(':gender', $gender);
    $insertStmt->bindParam(':address', $address);
    $insertStmt->bindParam(':course', $course);
    $insertStmt->bindParam(':cpnum', $cpnum);
    $insertStmt->bindParam(':pass', $password);
    $insertStmt->bindParam(':college', $college);

    if ($insertStmt->execute()) {
        // Student registered successfully
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Student registered successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } else {
        // Error registering student
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error registering student']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/registerStudent

Payload: {
    "id": "123456", 
    "email": "student@student.dmmmsu.edu.ph",
    "fullname": "John Doe",
    "dob": "1998-05-15", 
    "gender": "male",
    "address": "123 Main St, City",
    "course": "CIT",
    "cpnum": "1234567890",
    "pass": "student_password",
    "college": "CIT"
}

Response if successful:  
{
    "status": "success",
    "message": "Student registered successfully"
}

Response if there is error:
{
    "status": "error",
    "message": "Incomplete student information"
}

Response if invalid request
{
    "status": "error",
    "message": "Error registering student"
}
*/



///// Endpoint for Search Student ID ///// Adjusted by David Justine
$app->post('/searchStudent', function (Request $request, Response $response, array $args) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if the ID is provided in the request payload
    if (empty($data['id'])) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student ID is required']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $studentId = $data['id'];

    // Fetch student information from the database based on the student ID
    $stmt = $pdo->prepare("SELECT * FROM tbstuds WHERE ID = :student_id");
    $stmt->bindParam(':student_id', $studentId);
    $stmt->execute();
    $studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if student information is available
    if ($studentInfo) {
        // Return the response as JSON
        $response->getBody()->write(json_encode(['status' => 'success', 'data' => $studentInfo]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // No student found with the provided ID
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'No student found with the provided ID']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
});

/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/searchStudent

Payload:
{
    "id":123456 ///Student ID
}

Response if successful:  
{
    "status": "success",
    "data": {
        "ID": 123456,
        "email": "student@example.com",
        "fullname": "John Doe",
        "dob": "1998-05-15",
        "gender": "male",
        "address": "123 Main St, City",
        "course": "CIT",
        "cpnum": "1234567890",
        "pass": "stu",
        "college": "Example College"
    }
}

Response if there is error:
{
    "status": "error",
    "message": "No student found with the provided ID"
}

Response if invalid request
{
  "status": "error",
  "message": "Student ID is required"
}
*/



///// Endpoint for Updating Student Detail ///// Adjusted by David Justine
$app->post('/updateStudent', function (Request $request, Response $response) use ($pdo) {
    $data = $request->getParsedBody();

    if (!isset($data['id']) || empty($data['id'])) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student ID is required']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $studentId = $data['id'];

    // Validate other required fields
    $requiredFields = ['email', 'fullname', 'dob', 'gender', 'address', 'course', 'cpnum', 'pass', 'college'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Incomplete student information']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    // Fetch existing student
    $checkStmt = $pdo->prepare("SELECT * FROM tbstuds WHERE id = :student_id");
    $checkStmt->bindParam(':student_id', $studentId);
    $checkStmt->execute();
    $existingStudent = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingStudent) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student with the provided ID does not exist']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    // Update student information
    $updateStmt = $pdo->prepare("UPDATE tbstuds SET email = :email, fullname = :fullname, dob = :dob, gender = :gender, address = :address, course = :course, cpnum = :cpnum, pass = :password, college = :college WHERE id = :student_id");
    $updateStmt->bindParam(':student_id', $studentId);
    $updateStmt->bindParam(':email', $data['email']);
    $updateStmt->bindParam(':fullname', $data['fullname']);
    $updateStmt->bindParam(':dob', $data['dob']);
    $updateStmt->bindParam(':gender', $data['gender']);
    $updateStmt->bindParam(':address', $data['address']);
    $updateStmt->bindParam(':course', $data['course']);
    $updateStmt->bindParam(':cpnum', $data['cpnum']);
    $updateStmt->bindParam(':password', $data['pass']);
    $updateStmt->bindParam(':college', $data['college']);

    if ($updateStmt->execute()) {
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Student data updated successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error updating student data']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php//updateStudent

Payload: 
{
        "id": 123456,
        "email": "student@dmmmsu.edu.ph",
        "fullname": "John Doe",
        "dob": "1998-05-15",
        "gender": "male",
        "address": "123 Main St, City",
        "course": "CIT",
        "cpnum": "1234567890",
        "pass": "stu",
        "college": "Example College"
}

Response if successful:  
{
    "status": "success",
    "message": "Student data updated successfully"
}

Response if there is error:
{
    "status": "error",
    "message": "Incomplete student information"
}

Response if invalid request
{
    "status": "error",
    "message": "Error updating student data"
}
*/


///// Endpoint for Deleting Student Data ///// Adjusted by David Justine
$app->post('/deleteStudent', function (Request $request, Response $response) use ($pdo) {
    $data = $request->getParsedBody();

    // Check if the ID is provided in the request payload
    if (!isset($data['id']) || empty($data['id'])) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student ID is required']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $studentId = $data['id'];

    // Check if the student with the provided ID exists
    $checkStmt = $pdo->prepare("SELECT * FROM tbstuds WHERE id = :student_id");
    $checkStmt->bindParam(':student_id', $studentId);
    $checkStmt->execute();
    $existingStudent = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingStudent) {
        // Student with the provided ID does not exist
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Student with the provided ID does not exist']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    // Delete the student from the database
    $deleteStmt = $pdo->prepare("DELETE FROM tbstuds WHERE id = :student_id");
    $deleteStmt->bindParam(':student_id', $studentId);

    if ($deleteStmt->execute()) {
        // Student deleted successfully
        $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Student removed successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // Error deleting student
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Error deleting student']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});
/* METHOD: POST
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php//deleteStudent

Payload:
{
    "id": 123456
}

Response if successful:  
{
    "status": "success",
    "message": "Student removed successfully"
}

Response if there is error:
{
    "status": "error",
    "message": "Student ID is required"
}

Response if invalid request
{
    "status": "error",
    "message": "Error deleting student"
}
*/


///// Endpoint for Displaying Student Details /////
$app->get('/loadStudentInfo', function (Request $request, Response $response) use ($pdo) {
    // Fetch all student information from the database
    $stmt = $pdo->query("SELECT * FROM tbstuds");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any students
    if (!$students) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'No student information found']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    // Return the student information as JSON
    $response->getBody()->write(json_encode(['status' => 'success', 'data' => $students]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});
/* METHOD: GET
http://localhost/-CamVoxVotingSystem/public/api_endpoints.php//loadStudentInfo

Payload: N/A

Response if successful:  
{
    "status": "success",
    "data": [
        {
            "ID": 123456,
            "email": "student@example.com",
            "fullname": "John Doe",
            "dob": "1998-05-15",
            "gender": "male",
            "address": "123 Main St, City",
            "course": "CIT",
            "cpnum": "1234567890",
            "pass": "stu",
            "college": "Example College"
        },
        // ... (other student records)
    ]
}

Response if there is error:
{
    "status": "error",
    "message": "No student information found"
}
*/

$app->run();
?>