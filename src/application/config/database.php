<?php

/**
 * @author     Ajith E R, <ajithurulikunnam@gmail.com>
 * @date       September 11, 2017
 * @brief      Database connection related actions
 * @details    
 */
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$params = [
    'driver' => getenv('DB.MYSQL.DRIVER'),
    'host' => getenv('DB.MYSQL.HOST'),
    'database' => getenv('DB.MYSQL.NAME'),
    'username' => getenv('DB.MYSQL.USERNAME'),
    'password' => getenv('DB.MYSQL.PASSWORD'),
    'charset' => getenv('DB.MYSQL.CHARSET'),
    'collation' => getenv('DB.MYSQL.COLLATION'),
    'prefix' => getenv('DB.MYSQL.PREFIX')
];
$capsule->addConnection($params);
$capsule->setAsGlobal();
$capsule->bootEloquent();
