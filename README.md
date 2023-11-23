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
**LOGIN API**
1. **Identify API endpoint:**
   - Determine the endpoint for the login API. http://localhost/-CamVoxVotingSystem/public/login
     
2. **Prepare User Credentials**
   - Gather the user's credential, such as Student ID number, and default password.

3. **Construct API Request:**
   - Create a POST request to the login endpoint.
   - Set the request body with the user's credential in JSON format.

4. **Send API Request:**
   - Use Postman to make an HTTP request using preferred programming language to sent the request to the API.

5.**Receive API Response:**
   - Capture and parse the API response.

6. **Handle Success or Error:**
      - If the status is "sucess", extract the access token for future authenticated requests.
      - If the status is "error", handle the error message accordingly.

7. **Use Access Token For Authentication:**
      - If Successful, use the obtained access token in the Authorization header for subsequent requests to access protected resources


**INSERT CANDIDATE API**

1. **Identify API endpoint:**
   - Determine the endpoint for the insert candidate API. http://localhost/-CamVoxVotingSystem/public/insert_candidate
  
2. **Prepare the Candidate Data:**
   - Gather the candidate's details such as their name, position, party name and election code.

3. **Send the POST request:**
   - Send a post request to the API endpoint with the candidate data in JSON format.

4. **Check the respones:**

   - Inspect the response to see if the candidate insertion was successful.

## License
For educational purpose only.

## Contacts
**Front-End Developer Leader: Enrico Zephan A. Valdez**
   - Email: evaldez10602@student.dmmmsu.edu.ph
     
**Technical Documents Leader: Justine Raphael C. Necida**
   - Email: justineraphael.necida@student.dmmmsu.edu.ph
     
**Full Stack Developer Leader: Milven S. Gabayan**
   - Email: gabayan.allex996@gmail.com
     
**Backend Developer Leader: Neils Azer M. Agustin**
   - Email: ba218807@gmail.com
     
**Project Management Leader: Donell Carl G. Oconer**
   - Email: donellpie@gmail.com
     
**Tester: Aljen Lagarto**
   - Email: aljen.lagarto@student.dmmmsu.edu.ph




