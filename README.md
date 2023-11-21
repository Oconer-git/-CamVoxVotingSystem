# CamVoxVotingSystem
The  voting system offers students secure log-ins with student IDs, efficient election management, graphical result displays, and password recovery. With a user-friendly interface, it fosters engagement and trust in the democratic process.

## API for Login and Inserting Candidate
API for user authentication and candidate insertion in CamVoxVoting System.

## API Description
This API facilitates secure user access to the voting system and allows for the dynamic management of candidates within the system, ensuring that it remains accurate and reflects the current candidates participating in the electoral process.

## API Endpoints
The following are the endpoints for login and insertion of candidates into the system:

1. **Login API**
   - Endpoint: `/login`
   - Method: `POST`
   - Description: Allow users to authenticate themselves and obtain the necessary credentials to access a system.

2. **Inserting Candidate API**
   - Endpoint: `/insert_candidate`
   - Method: `POST`
   - Description: Inserts a new candidate into the voting system.

## Request Payload
**Request Payload for Login**

```json
{
    "id": "string",        // Student ID
    "pass": "string"       // Deafault Password
}
```

**Request Payload for Candidate Insertion**

```json
{
    "name" : "",
    "posName" : "",
    "partyName" : "",
    "electioncode" : ""
}
```


## Response
1. **API Login**
   - Success Response:

      ```json
      {
        "status": "success",
        "message": "Login successful. Welcome, $user['fullname']"
      }
      ```

   - Error Response: User not found
     
      ```json
      {
        "status": "error",
        "message": "User not found"
      }
      ```
   - Error Response: Invalid Password
  
      ```json
      {
        "status": "error",
        "message": "Invalid password"
      }
      ```

2. **Candidate Insertion**
   - Success Response:
   
     ```json
     {
       "status": "success",
       "message": "Candidate data inserted successfully"
     }
     ```
   - Error Response: Missing candidate data

     ```json
     {
        "status": "error",
        "message": "Missing candidate data"
     }
     ```
   - Error Response: Error inserting candidate data

     ```json
     {
        "status": "error",
        "message": "Error inserting candidate data"
     }
     ```
     
## Usage
Usage of API...

## License
For educational purpose only.

## Contacts
Contacts of leaders in each department...


