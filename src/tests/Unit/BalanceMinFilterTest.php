<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use App\DataProvider\Filters\BalanceMinFilter;

class BalanceMinFilterTest extends TestCase
{
    /**
     * Test return true when filter is valid.
     */
    public function test_itemIsValid_return_true(): void
    {
        $mockRequest = Request::create('/api/v1/users', 'GET', ["balanceMin"=>50]);
        $filterClass = new BalanceMinFilter();
        $this->assertTrue($filterClass->itemIsValid([$filterClass->attribute => 100], $mockRequest));

    }

    /**
     * Test return false when item not valid
     */
    public function test_itemIsValid_return_false(): void
    {
        $mockRequest = Request::create('/api/v1/users', 'GET', ["balanceMin"=>50]);
        $filterClass = new BalanceMinFilter();
        $this->assertFalse($filterClass->itemIsValid([$filterClass->attribute => 40], $mockRequest));

    }
}
