<?php

namespace Pavlyshyn\Trading;

use Pavlyshyn\Bitfinex\Client;

class Bitfinex implements TradingInterface {


    protected $apiKey = null;
    protected $apiSecret = null;
    protected $apiVersion = 'v1';
    protected $clientV1 = null;
    protected $clientV2 = null;


    private $symbolsMap = [];


    public function __construct($apiKey = null, $apiSecret = null, $apiVersion = 'v1') {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiVersion = $apiVersion;

        $this->clientV1 = new Client($this->apiKey, $this->apiSecret);
        $this->clientV2 = new Client($this->apiKey, $this->apiSecret, 'v2');
    }


    /**
     * Used to get the last 24 hour summary of all active exchanges
     * @return mixed
     */
    public function marketSummaries() {
        $query = '';
        $symbols = [];
        $symbolsTmp = $this->clientV1->get_symbols();
        foreach($symbolsTmp as $k=>$symbol) {
            $tinker = 't'.strtoupper($symbol);
            $symbols[] .= $tinker;
        }
        $query = implode(',', $symbols);

        $tickers = $this->clientV2->get_tickers($query);

        return $this->makeResult($tickers);
    }


    private function makeResult($array) {
        $result = [];

        for($j=0; $j<sizeof($array); $j++) {

            $result[$j]['SYMBOL'] = $array[$j][0];
            $result[$j]['BID'] = $array[$j][1];
            $result[$j]['BID_SIZE'] = $array[$j][2];
            $result[$j]['ASK'] = $array[$j][3];
            $result[$j]['ASK_SIZE'] = $array[$j][4];
            $result[$j]['DAILY_CHANGE'] = $array[$j][5];
            //$result[$j]['DAILY_CHANGE_PERC'] = $DAILY_CHANGE_PERC;
            $result[$j]['LAST_PRICE'] = $array[$j][7];
            $result[$j]['VOLUME'] = $array[$j][8];
            $result[$j]['HIGH'] = $array[$j][9];
            $result[$j]['LOW'] = $array[$j][10];

            $orders = $this->clientV1->get_book(str_replace('t', '', $result[$j]['SYMBOL']));
            $result[$j]['BUY_VOLUME'] = 0;
            $result[$j]['SELL_VOLUME'] = 0;
            foreach($orders['bids'] as $order) {
                $result[$j]['BUY_VOLUME'] += $order['amount'];
            }
            foreach($orders['asks'] as $order) {
                $result[$j]['SELL_VOLUME'] += $order['amount'];
            }
        }

        return $result;
    }

}
