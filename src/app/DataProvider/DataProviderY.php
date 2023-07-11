<?php

namespace App\DataProvider;

use Carbon\Carbon;
use App\DataProvider\Concern\JsonProviderBase;

class DataProviderY extends JsonProviderBase
{
    protected $statusCode = [
        '100'  => 'authorised',
        '200'  => 'decline',
        '300'  => 'refunded'
    ];

    public function getFilePath()
    {
        return storage_path("data/DataProviderY.json");
    }

    public function casting($item)
    {
        return [
                'id'          => $item->id,
                'parentEmail' => $item->email,
                'amount'      => $item->balance,
                'currency'    => $item->currency,
                'status'      => $this->statusCode[$item->status],
                'created_at'  => Carbon::createFromFormat('d/m/Y', $item->created_at)->format("Y-m-d"),
                'provider'    => 'DataProviderY',
        ];
    }
}
