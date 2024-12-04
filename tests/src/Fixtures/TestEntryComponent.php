<?php

namespace Awcodes\Typist\Tests\Fixtures;

use Filament\Infolists\Infolist;

class TestEntryComponent extends TestInfolist
{
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'content' => null,
            ])
            ->schema([
                //
            ]);
    }
}
