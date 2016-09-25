<?php

require __DIR__ . '/../app/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$arguments = $request->query->get('name', ', comment vas-tu ?');

$response = new Response(sprintf('Hello %s', htmlspecialchars($arguments, ENT_QUOTES, 'UTF-8')));
$response->setStatusCode(200);
$response->headers->set('Content-Type', 'text/html');
$response->setMaxAge(25);

$response->send();