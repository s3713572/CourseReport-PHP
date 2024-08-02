****About the project****
![image](https://github.com/user-attachments/assets/69dbef8e-efab-4a29-b65a-047017dbd08a)

**Built with:**
ReactJs,
PHP,
Material UI,
Axios,
Docker

****Getting Started****

**Installations:**
1. git clone git@github.com:s3713572/CourseReport-PHP-React.git
2. cd into the backend and vite-project individually
3. In the backend src>db>scheme.sql, it includes the database structure:
![image](https://github.com/user-attachments/assets/813d2f93-ffa9-4477-a393-fb94ef1c11c8)

Without a backend framework, lets just quick download a mysqlworkbench and run these sql statements to create database and tables manually.
Login to mysqlworkbench with corresponding username and password, which are stated in docker-compose.yml

![image](https://github.com/user-attachments/assets/685d2545-0e0b-42ae-af6d-1e60fe55368b)

![image](https://github.com/user-attachments/assets/628c1d5f-8890-462a-a45d-355f4f1d9d22)



<<<<<<< HEAD
4. For backend:
   Making sure you are at the right folder
   Making sure the docker desktop is running
   Run command: `make bash`
                `make db-setup`
                `make seeds`
   (This helps generating 100+ records into the database)
6. Finally, run command:
   `docker-compose up`
=======
****Backend Setup****
>>>>>>> d0992264fe5f5f3b77f1d12c2c32d719be0120cb

**Ensure Correct Directory**

Navigate to the appropriate folder where the backend code resides.

**Check Docker Desktop**

Verify that Docker Desktop is running on your machine.

Run `docker-compose build`

**Initialize the Database**

Run the following commands to set up the database and populate it with sample data:

`make bash`
`make db-setup`
`make seeds`

Note: The make seeds command generates over 100 records in the database.

-------------------------------------------------------------------------------------------------------------------------

**Start Backend Services**

Execute the following command to start all necessary backend services:

`docker-compose up`

-------------------------------------------------------------------------------------------------------------------------

****Frontend Setup****

**Ensure Correct Directory**

Navigate to the directory containing the frontend code.

**Check pnpm Installation**

Confirm that pnpm is installed on your system.

**Install Dependencies**

Run the following command to install all dependencies specified in your package.json file:

`pnpm install`

`pnpm run dev`

-------------------------------------------------------------------------------------------------------------------------

Class: Meta

The Meta class is used to encapsulate metadata about the response.

Properties:

message (string): A message related to the response.

page (int|null): The current page number in pagination.

per (int|null): The number of items per page in pagination.

total (int|null): The total number of items.


PHP JSON Response Helper

This repository contains helper functions for sending JSON responses from a PHP backend. It includes methods for sending success and error responses with metadata.

Overview

The helper functions in this code help to standardize the JSON responses sent by the server. This is particularly useful for APIs to ensure consistency in responses.

Classes and Functions

Class: Meta

The Meta class is used to encapsulate metadata about the response.

Properties:

message (string): A message related to the response.

page (int|null): The current page number in pagination.

per (int|null): The number of items per page in pagination.

total (int|null): The total number of items.


function __construct($message = '', $page = null, $per = null, $total = null)

$message: An optional message for the response.

$page: The current page number.

$per: The number of items per page.

$total: The total number of items.

-----------------------------------------------

Function: echoJSON

Sends a JSON response with custom metadata and status code.

Parameters:

$data (mixed): The data to be included in the response.

$meta (Meta): An instance of the Meta class containing metadata.

$code (int): The HTTP status code to return.

-----------------------------------------------

Function: echoSuccess

Convenience function for sending a successful response.

Parameters:

$data (mixed): The data to be included in the response.

$meta (Meta): An optional instance of the Meta class containing metadata. Defaults to a new Meta instance with an empty message.

$code (int): The HTTP status code to return. Defaults to 200.

-----------------------------------------------

Function: echoError

Convenience function for sending an error response.

Parameters:

$message (string): The error message to include in the response.

$code (int): The HTTP status code to return. Defaults to 500.

-----------------------------------------------

Requirements：

PHP 7.0 or higher
