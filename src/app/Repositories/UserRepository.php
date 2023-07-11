<?php

namespace App\Repositories;

use App\DataProvider\Filters\StatusCodeFilter;

class UserRepository
{
    protected $dataProviders = [
        "DataProviderX" => \App\DataProvider\DataProviderX::class ,
        "DataProviderY" => \App\DataProvider\DataProviderY::class
    ];

    public function getUsers($request)
    {
        return $this->collectDataFromProviders($request);
    }

    public function collectDataFromProviders($request)
    {
        if($request->provider && isset($this->dataProviders[$request->provider])) {
            return (new $this->dataProviders[$request->provider]())
                   ->setRequest($request)
                   ->getData()
            ;
        }

        $data = [];
        foreach ($this->dataProviders as $provider) {
            $data =  array_merge(
                $data,
                (new $provider())
                 ->setRequest($request)
                 ->getData()
            );
        }
        return $data;
    }

}
