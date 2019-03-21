<?php

namespace Bean\Activity\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return ['Bean\Activity\ServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->singleton(\Illuminate\Database\Eloquent\Factory::class, function ($app){
            return \Illuminate\Database\Eloquent\Factory::construct($app->make(\Faker\Generator::class), __DIR__ . '/../database/factories');
        });
    }
}
