<?php

namespace App\DataProvider\Concern;

use Illuminate\Support\Facades\Cache;
use JsonMachine\Items;

/**
 * JsonProviderBase class
 */
abstract class JsonProviderBase
{
    protected $data = [];
    protected $filters = [];
    protected $request = null;

    protected $filterConfig = [
        "statusCode" =>  \App\DataProvider\Filters\StatusCodeFilter::class ,
        "currency"   => \App\DataProvider\Filters\CurrencyFilter::class ,
        "balanceMin" => \App\DataProvider\Filters\BalanceMinFilter::class,
        "balanceMax" => \App\DataProvider\Filters\BalanceMaxFilter::class
    ];

    abstract public function getFilePath();

    abstract public function casting($item);

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function setFilters()
    {
        foreach ($this->filterConfig as $key => $filterClass) {
            if($this->request->has($key)) {
                $this->filters[] = new $filterClass();
            }
        }
        return $this;
    }

    public function getData()
    {
        $this->setFilters();
        if(config("data.allow_cache")) {
            $this->getDataFromCache();
        } else {
            $this->getDataFromFile();
        }
        return $this->data;
    }

    public function emptyData()
    {
        $this->data = [];
        return $this;
    }

    public function getDataFromFile()
    {

        $this->data = $this->readData();
        return $this;
    }

    protected function readData()
    {
        $out     = [];
        $origin  = Items::fromFile($this->getFilePath());
        foreach ($origin as $item) {
            $item  = $this->casting($item);
            if($this->checkFilter($item)) {
                $out[] = $item;
            }

        }
        return $out;
    }

    public function checkFilter($item)
    {
        if(count($this->filters) == 0) {
            return true;
        }

        foreach ($this->filters as $filter) {
            if($filter->itemIsValid($item, $this->request)== false) {
                return false;
            }
        }
        return true;
    }

    public function getDataFromCache()
    {
        $this->data = Cache::rememberForever($this->getCacheKey(), function () {
            return $this->readData();
        });
        return $this;
    }

    public function getCacheKey()
    {
        return 'f-'.md5(
            "{$this->getFilePath()}-{$this->request->getRequestUri()}"
        );
    }

}
