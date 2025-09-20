<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Personal Information Fields
            ]);
    }
}
