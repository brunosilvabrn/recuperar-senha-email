<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/config.php';

use App\controller\appController;

$application = new appController();

$application->app();


