<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class SecondIterationTest extends TestCase
{
    /**
     * This is a basic test to ensure that the inventory page loads with a 200
     * status.
     *
     * @return void
     */
    public function testInventoryPageOpens()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    public function testGetItemsPostRequest()
    {
        Session::start();

        $response = $this->call('POST', '/getItems/0', [
            '_token' => Session::token()
        ]);
        
        $response->assertStatus(200);
    }
}
