<?php

namespace App\DataProvider\Filters;

interface IFilter
{
    public function itemIsValid($item, $request);
}
