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


4. For backend:
   Making sure you are at the right folder
   Making sure the docker desktop is running
   Run command: make bash
                make seeds
   (This helps generating 100+ records into the database)
6. Finally, run command:
   docker-compose up

7. For frontend:
   Making sure you are at the right folder
   Making sure you have pnpm installed

   Run `pnpm install` to install all the dependencies specified in your `package.json` file.

   Finally Run `pnpm run dev`
