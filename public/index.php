<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

require '../vendor/autoload.php';

use FrontController\FrontController;

$uri = '/home';
$method = 'GET';

$frontController = new FrontController($uri, $method);
$frontController->dispatchRequest('../routes/app.php');
