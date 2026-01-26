# COP4331C-Small-Project

Disclaimer, we haven't met in person yet so I understand none of this is final, this is just a base format we could possibly follow. I'm comfortable with whatever we choose.

## Local Setup

### Requirements
- PHP 8.4.16 (cli) must be installed: [Install Guide](https://www.php.net/manual/en/install.php)
- Docker Desktop must be installed: [Install Guide](https://docs.docker.com/desktop/)

### Steps
1. Download the code for the project. You can get a zip file of it from the green code drop down.
2. Open a terminal window in ./Server
3. Run ``docker run --name test-sql -e MYSQL_ROOT_PASSWORD=root -p 3306:3306 -d mysql:latest`` as an administrator
4. Run ``docker exec test-sql mysql -uroot -proot -e "CREATE DATABASE test;"`` as an administrator
5. Run ``php -S localhost:8000``
   1. You might encounter an issue when loading the page, "Connection failed...", this is because docker set your container port to something else.
   2. Run ``docker ps``, then notice the "PORTS" column
   3. If you see 0.0.0.0:OTHERPORT -> 3306/tcp, your port was set to OTHERPORT for access.
   4. Go to /Server/components/db.php and change the string next to $port to OTHERPORT.
6. You should now see login.html on http://localhost:8000

---

## To-Do
Please review and update this section with any additional tasks required to complete the project. This may be migrated to Trello later if needed.

- [ ] Write SQL for creating user accounts in `Server/components/register.php`
- [ ] Develop Login API that serves cookies on response
- [ ] Complete register API (must return cookie to allow user access to contacts upon registration)
- [ ] Build Contacts API to display all contacts (paginated)
- [ ] Implement Search API (paginated)
- [ ] Create delete API
- [ ] Review MySQL options in `/Server/components/db.php` to prevent SQL injection (not sure if this would be part of the rubric).

---

## REST API
**Note:** This section will be updated once proper API documentation methods are established in class. 

All APIs should be referenced through the same URL as the main domain (unless a subdomain is implemented). Use the following format:

```javascript
fetch(`${window.location}/?api=INSERT_API_ACTION`, {
    method: 'GET', // or POST depending on action
    headers: {}
})
```


### API Actions
`api=login` / POST  
Creates a new login session for the user and returns a cookie.

**Request Body:**
```json
{
  "username": "",
  "password": ""
}
```  

**`api=register` / POST**
Creates a new login session for the user if their username is unique and no other issues occur.

**Request Body:**  
```json
{}
```  

**`api=contacts` / GET**  
Retrieves the first 50 contacts of the user and returns the total number of pages available.

**Request Queries:**  
```url
?api=contacts&page=0
```  

**`api=search` / GET**  
Retrieves the first 50 contacts of the user that match the search criteria and returns the total number of pages for the filtered results.

**Request Queries:**  
```url
?api=contacts&page=0
``` 

**`api=delete` / POST**  
Deletes a specified user contact.

**Request Body:**  
```json
{}
```  

---

## AI Assistance Disclosure

This project was developed with assistance from generative AI tools:

- **Tool**: Qwen3 8b (Alibaba Cloud, lmstudio.ai/models/qwen/qwen3-8b)
- **Dates**: January 22nd, 2026
- **Scope**: Boiler plate for the README.md file sections "To-Do" and "REST API".
- **Use**: Generated the specified format for the README.md while providing reasoning for changes to sentence format if needed. Sections were edited and the "Local Setup" section was written manually to ensure its quality. 

No code, commands, or information was generated. The format itself is the only thing the model generated and that was edited as well.