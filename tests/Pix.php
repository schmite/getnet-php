<?php
use Getnet\API\Getnet;
use Getnet\API\Environment;
use Getnet\API\PixTransaction;

include "../vendor/autoload.php";


$client_id      = "3a666a8c-6d97-4eb0-a62c-77e3758c3425";
$client_secret  = "f52a2358-70e6-4baa-b77f-9f0eeb7c8706";
$seller_id      = "c695b415-6f2e-4475-a221-3c005258a450";
$environment    = Environment::sandbox();

//Autenticação da API
$getnet = new Getnet($client_id, $client_secret, $environment);

// Need add seller_id in Header PIX
$getnet->setSellerId($seller_id);

//Cria a transação
$transaction = new PixTransaction(75.50);
$transaction->setCurrency("BRL");
$transaction->setOrderId('DEV-1608748980');
$transaction->setCustomerId('12345');


$response = $getnet->pix($transaction);

var_dump($response);

