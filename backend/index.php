<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/src/routes/main.php";

use Dotenv\Dotenv;
use App\Core\Core;
use App\Http\Route;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
Core::dispatch(Route::routes());
