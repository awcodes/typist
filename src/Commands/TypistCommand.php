<?php

namespace Awcodes\Typist\Commands;

use Illuminate\Console\Command;

class TypistCommand extends Command
{
    public $signature = 'typist';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
