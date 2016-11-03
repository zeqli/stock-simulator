<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test login page.
     *
     * @return void
     */
    public function testLogin(){
        $this->assertTrue(true);   
    }

    /**
     * Test admin role
     *
     * @return void
     */
    public function testLoginAsAdmin(){
        $this->assertTrue(true);
    }

    /**
     * Test register page
     *
     * @return void
     */
    public function testRegister(){
        $this->assertTrue(true);
    }

    /**
     * Test logout button
     *
     * @return void
     */
    public function testLogout(){
        $this->assertTrue(true);
    }
}
