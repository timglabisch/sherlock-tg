<?php

namespace Tg\Sherlock;
use \Tg\Sherlock\Request\SearchRequest;

class Sherlock extends \Sherlock\Sherlock {
    public function _raw() {
        return new SearchRequest($this->settings['event.dispatcher']);
    }
}