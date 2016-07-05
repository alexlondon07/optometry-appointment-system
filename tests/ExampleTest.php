<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class ExampleTest extends TestCase
{

    use WithoutMiddleware;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Login');
    }

    /**
     * Working With Databases
     * Test Validar que si exita el Usuario Administradorl
     * [testUsersAll description]
     * @return [type] [description]
     */
    public function testDataUser()
    {
        $this->seeInDatabase('users', ['name'=>'Alexander andres londoño espejo', 'email' => 'admin@admin.com']);
    }


    /**
     * Test para el ingreso a la aplicacion
     * [testSuccessfullLogin description]
     * @return [type] [description]
     */
     public function testSuccessfullLogin() {
       $this->withSession(['title' => 'Clean room','summary'=>'Clean Room','files'=>'no'])
       ->visit('/')
       ->type('admin@admin.com','email')
       ->type('admin','password')
       ->press("Ingresar")
       ->see("Bienvenido al sistema");
    }
}
