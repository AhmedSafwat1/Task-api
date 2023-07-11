<?php

namespace App\DataProvider;

use App\DataProvider\Concern\JsonProviderBase;

class DataProviderX extends JsonProviderBase
{
    protected $statusCode = [
        '1'  => 'authorised',
        '2'  => 'decline',
        '3'  => 'refunded'
    ];

    public function getFilePath()
    {
        return storage_path("data/DataProviderX.json");
    }

    public function casting($item)
    {
        return [
            'id'          => $item->parentIdentification ,
            'parentEmail' => $item->parentEmail ,
            'amount'      => $item->parentAmount,
            'currency'    => $item->Currency,
            'status'      => $this->statusCode[$item->statusCode] ?? null,
            'created_at'  => $item->registerationDate ,
            'provider'    => 'DataProviderX',
        ];
    }
}
