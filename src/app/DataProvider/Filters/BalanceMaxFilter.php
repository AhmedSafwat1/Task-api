<?php

namespace App\DataProvider\Filters;

use App\DataProvider\Filters\IFilter;

class BalanceMaxFilter implements IFilter
{
    public $params ="balanceMax";
    public $attribute = "amount";

    public function itemIsValid($item, $request)
    {
        if(
            !$request->has($this->params)  ||
             ($request->input($this->params) !=0 && empty($request->input($this->params)))
        ) {
            return true;
        }
        return $item[$this->attribute] <= $request->input($this->params);
    }
}
