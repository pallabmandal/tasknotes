## Dependencies
- In order to install this project, we need to have mysql installed, and we need php7.4+ along with all the necessary php extensions
- We need composer in order to install laravel. [PHP Composer](https://getcomposer.org/doc/00-intro.md).

## Installing
- Take a pull of the project from [github](https://github.com/pallabmandal/teasknote)
- Go inside the project folder
- Copy the .env.example to .env
- Set up the database credentials in the .env file
- run ``` composer install ```
- run ``` php artisan migrate ```
- Create the defaule user from seeder ```  php artisan db:seed --class="UserSeeder"  ```
- run ``` php artisan passport:install ```
- run ``` php artisan key:generate ```
- change permission of storea and bootstrap/cache ``` sudo chmod 777 -R storage/ bootstrap/cache/ ```
- run ``` php artisan serve ``` this will start the server on localhost port 8000
- run ``` php artisan storage:link ``` 

## API
- The postman environment will be found [HERE](https://drive.google.com/file/d/1kX_lq3rpYOPSxzmhA-OEAir0ycnk2LE7/view?usp=sharing)
- The postman collection will be found [HERE](https://drive.google.com/file/d/1Ejov98SVOV35LFjGLoP5MiZ9Anu_dV5W/view?usp=sharing)