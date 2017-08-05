<?php

namespace Pavlyshyn\Trading;

use AndreasGlaser\PPC\PPC;


class Poloniex implements TradingInterface {

    private $ppc;

    public function __construct() {
        $this->ppc = new PPC();
    }


    public function marketSummaries() {
        $result = $this->ppc->getTicker();


        return $result;
    }
}
