<?php

namespace Tg\Sherlock\Request;
use \Sherlock\requests\Command;

class SearchRequest extends \Sherlock\requests\SearchRequest {

    function execute() {

        if(!isset($this->params['raw']) || !is_array($this->params['raw']))
            throw new \InvalidArgumentException('"raw" must be a array');

        $finalQuery = json_encode($this->params['raw']);

        if (isset($this->params['index'])) {
            $index = implode(',', $this->params['index']);
        } else {
            $index = '';
        }

        if (isset($this->params['type'])) {
            $type = implode(',', $this->params['type']);
        } else {
            $type = '';
        }

        if (isset($this->params['endpoint'])) {
            $endpoint = $this->params['endpoint'];
        } else {
            $type = '_search';
        }

        if (isset($this->params['search_type'])) {
            $queryParams[] = $this->params['search_type'];
        }

        if (isset($this->params['routing'])) {
            $queryParams[] = $this->params['routing'];
        }

        if (isset($queryParams)) {
            $queryParams = '?' . implode("&", $queryParams);
        } else {
            $queryParams = '';
        }

        $command = new Command();
        $command->index($index)
            ->type($type)
            ->id($this->params['endpoint'] . $queryParams)
            ->action('post')
            ->data($finalQuery);

        $this->batch->clearCommands();
        $this->batch->addCommand($command);

        // call the parents parent.
        // todo: for now we use the queryReponse
        // this force elasticsearch to have the fields "took" and "timed_out".
        // this fields may doesnt exists for a RawResponse.
        $ret = @\Sherlock\requests\Request::execute();

        return $ret;
    }
}