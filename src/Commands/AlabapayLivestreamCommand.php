<?php

namespace Alabapay\AlabapayLivestream\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AlabapayLivestreamCommand extends Command
{
    public $signature = 'alabapay-livestream:setup';

    public $description = 'Setup alabapay-livestream package';

    public function handle(): int
    {

        $this->comment("Publish config files");
        Artisan::call("vendor:publish --tag='alabapay-livestream-config'");

        $this->comment("Publish migration files");
        Artisan::call("vendor:publish --tag='alabapay-livestream-migrations'");

        $this->comment("Migrating...");
        Artisan::call("migrate");

        $this->comment('alabapay-livestream package setup successfully');

        return self::SUCCESS;
    }
}
