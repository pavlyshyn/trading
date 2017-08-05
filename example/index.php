<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pavlyshyn\Trading\Bitfinex;
use Pavlyshyn\Trading\Bittrex;
//use Pavlyshyn\Trading\Poloniex;


$bitfinex = new Bitfinex();
$bittrex = new Bittrex();
//$poloniex = new Poloniex();

$bitfinexResult = $bitfinex->marketSummaries();
$bittrexResult = $bittrex->marketSummaries();
//$poloniexResult = $poloniex->marketSummaries();

//print_r($bitfinexResult[0]);
//print_r($poloniexResult);

foreach($bitfinexResult as $item) {
    if($item['SYMBOL'] == 'tBTCUSD') {
        print_r($item);
    }
}


//print_r($bittrexResult[0]);

foreach($bittrexResult as $item) {
    if($item['SYMBOL'] == 'USDT-BTC') {
        print_r($item);
    }
}
