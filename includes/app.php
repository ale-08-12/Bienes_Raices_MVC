<?php

require __DIR__ . "/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::CreateImmutable(__DIR__);
$dotenv->safeLoad();

require "funciones.php";
require "config/database.php";

use Modelo\ActiveRecord;
ActiveRecord::setDB(conectarDB());