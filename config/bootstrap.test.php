<?php
use Getnet\API\Getnet;
use Getnet\API\Environment;

$ROOTDIR = dirname(__DIR__);

require_once $ROOTDIR . '/vendor/autoload.php';

// for local development copy config/env.test.php.txt to config/env.test.php and add your credentials
require_once $ROOTDIR . '/config/env.test.php';

/**
 *
 * @return Getnet
 * @throws Exception
 */
function getnetServiceTest()
{
    $getnet = new Getnet(getenv('GETNET_CLIENT_ID'), getenv('GETNET_CLIENT_SECRET'), Environment::sandbox());

    $getnet->setSellerId(getenv('GETNET_SELLER_ID'));

    return $getnet;
}