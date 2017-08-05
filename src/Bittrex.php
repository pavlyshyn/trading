<?php


namespace Pavlyshyn\Trading;

use Pavlyshyn\Bittrex\Client;

class Bittrex implements TradingInterface {
    protected $apiKey = null;
    protected $apiSecret = null;
    protected $client = null;

    private $keys = [
        'SYMBOL',
        'BID',
        'BID_SIZE',
        'ASK',
        'ASK_SIZE',
        'DAILY_CHANGE',
        'DAILY_CHANGE_PERC',
        'LAST_PRICE',
        'VOLUME',
        'HIGH',
        'LOW'
    ];

    public function __construct($apiKey = null, $apiSecret = null) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

        $this->client = new Client($this->apiKey, $this->apiSecret);
    }

    public function marketSummaries() {
        $tickers = $this->client->marketSummaries();

        return $this->makeResult($tickers);
    }


    private function makeResult($out_array) {
        $result = [];
        $array = $out_array;

        for($j=0; $j<sizeof($array); $j++) {
            $DAILY_CHANGE = $array[$j]['Last']-$array[$j]['PrevDay'];
            $VOLUME = $array[$j]['Volume'];//*$array[$j]['Last'];

            $result[$j]['SYMBOL'] = $array[$j]['MarketName'];
            $result[$j]['BID'] = $array[$j]['Bid'];
            $result[$j]['BID_SIZE'] = $array[$j]['OpenSellOrders'];
            $result[$j]['ASK'] = $array[$j]['Ask'];
            $result[$j]['ASK_SIZE'] = $array[$j]['OpenBuyOrders'];
            $result[$j]['DAILY_CHANGE'] = $DAILY_CHANGE;
            //$result[$j]['DAILY_CHANGE_PERC'] = $DAILY_CHANGE_PERC;
            $result[$j]['LAST_PRICE'] = $array[$j]['Last'];
            $result[$j]['VOLUME'] = $VOLUME;
            $result[$j]['HIGH'] = $array[$j]['High'];
            $result[$j]['LOW'] = $array[$j]['Low'];
        }

        return $result;
    }

}
