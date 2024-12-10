<?php

namespace Alabapay\AlabapayLivestream\Commands;

use Illuminate\Console\Command;

class AlabapayLivestreamCommand extends Command
{
    public $signature = 'alabapay-livestream';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
