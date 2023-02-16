# Payme-project

Technologies : Php,Laravel,Mysql,Docker
# To run the project


- Clone the project.
- cd to root directory and run.
1) composer install
2) php artisan migrate
3) docker-compose up (for db access)
4) paste the following in your .env file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=user
DB_PASSWORD=password

5) run php artisan serve

6) to use the UI , go to http://localhost:8000/form

7) tests: run the command php artisan tests




# endpoints:
- GET getPayments localhost:8000/payments 
- POST createPayment  localhost:8000/payment
- PUT updatePayment localhost:8000/payment/{id}
- DELETE deletePayment localhost:8000/payment/{id}

- If you are using postman , you can view the postman collection and import it if needed


