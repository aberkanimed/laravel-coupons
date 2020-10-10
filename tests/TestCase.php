<?php

namespace aberkanidev\Coupons\Tests;

use Illuminate\Foundation\Auth\User;
use aberkanidev\Coupons\Facades\Coupons;
use Illuminate\Database\Schema\Blueprint;
use aberkanidev\Coupons\CouponsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations(['--database' => 'sqlite']);
        $this->setUpDatabase();
        $this->createUser();
    }

    protected function getPackageProviders($app)
    {
        return [
            CouponsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Coupons' => Coupons::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase()
    {
        include_once __DIR__ . '/../database/migrations/create_coupons_table.php.stub';
        (new \CreateCouponsTable())->up();

        $this->app['db']->connection()->getSchemaBuilder()->create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('gifters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    protected function createUser()
    {
        User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test'
        ]);
    }
}
