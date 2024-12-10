<?php

namespace Alabapay\AlabapayLivestream;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Alabapay\AlabapayLivestream\Commands\AlabapayLivestreamCommand;

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
            ->name('alabapay-livestream')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_alabapay_livestream_table')
            ->hasCommand(AlabapayLivestreamCommand::class);
    }
}
