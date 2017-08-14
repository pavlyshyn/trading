<?php

namespace Pavlyshyn\Trading;

use AndreasGlaser\PPC\PPC;


class Poloniex implements TradingInterface {

    private $ppc;

    public function __construct() {
        $this->ppc = new PPC();
    }


    public function marketSummaries() {
        $tickers = $this->ppc->getTicker();

        return $this->makeResult($tickers);
    }

    private function makeResult($out_array) {
        $result = [];
        $array = $out_array;

        foreach($array as $k=>$v) {
            for($i=0; $i<sizeof($v[$j]); $i++) {
                $result[$j]['SYMBOL'] = $k;
                $result[$j]['BID'] = $v[$j]['highestBid'];
                $result[$j]['BID_SIZE'] = 0;
                $result[$j]['ASK'] = $v[$j]['lowestAsk'];
                $result[$j]['ASK_SIZE'] = 0;
                $result[$j]['DAILY_CHANGE'] = 0;
                $result[$j]['LAST_PRICE'] = $v[$j]['last'];
                $result[$j]['VOLUME'] = $v[$j]['baseVolume'];
                $result[$j]['HIGH'] = $v[$j]['high24hr'];
                $result[$j]['LOW'] = $v[$j]['low24hr'];

                $result[$j]['BUY_VOLUME'] = 0;
                $result[$j]['SELL_VOLUME'] = 0;
            }
        }

        return $result;
    }
}
