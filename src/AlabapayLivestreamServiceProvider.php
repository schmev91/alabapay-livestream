<?php

namespace Alabapay\AlabapayLivestream;

use Alabapay\AlabapayLivestream\Commands\AlabapayLivestreamCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AlabapayLivestreamServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name("alabapay-livestream")
            ->hasCommand(AlabapayLivestreamCommand::class)
            ->hasConfigFile()
            ->hasRoute("api")
            ->hasMigration("create_alabapay_livestream_tables");
    }
}
