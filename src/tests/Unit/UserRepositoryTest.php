<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    /**
     * Test if get users will  return array
     */
    public function test_getUsers_return_array(): void
    {
        $mockRequest = Request::create('/api/v1/users', 'GET', ["balanceMin"=>50]);
        $repo = new UserRepository();
        $this->assertTrue(is_array($repo->getUsers($mockRequest)));
        
    }
}
