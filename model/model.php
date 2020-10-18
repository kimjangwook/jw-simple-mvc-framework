<?php

namespace App\Model;

use PDO;

class Model
{
    public $pdo;

    public function __construct() 
    {
        try {
            switch (strtoupper($_ENV['DB_CONNECTION'])) {
                case 'MYSQL':
                    $dsn = 'mysql:dbname=' . $_ENV['DB_DATABASE'] . ';'
                           . 'host=' . $_ENV['DB_HOST'] . ';'
                           . 'port=' . $_ENV['DB_PORT'] . ';'
                           . 'charset=utf8';
                    $this->pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                    break;
                case 'SQLITE':
                    $dbFile = isset($_ENV['DB_FILENAME']) ?  $_ENV['DB_FILENAME'] : 'database.sqlite';
                    
                    $this->pdo = new PDO('sqlite:../' . $dbFile);
                    break;
                default:
                    die('No Connection');
                    break;
            }

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(\Exception $e) {
            die($e->getMessage());
        }
    }
}