Symfony User Api and Authentication project
create a .env.local file and enter the DatabaseUrl in the format below, replacing all the variables in angled brackets:
DATABASE_URL="mysql://<db_user>:<db_pass>@<db_host>:<db_port>/<db_name>?serverVersion=8.0.32&charset=utf8mb4"
Also create a .env.test.local file and enter the database url ensuring the db_name is the name of the test database
Then run composer install
View the API documentation on localhost/api on the browser
