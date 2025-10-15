<?php

namespace App\Filament\Resources\StartUpYourNewLives\Schemas;

use App\Models\Member;
use App\Filament\Traits\HasVipMemberFields;
use App\Filament\Traits\HasLessonFormFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class StartUpYourNewLifeForm
{
    use HasVipMemberFields;
    use HasLessonFormFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberFieldForNewLife(),
                
                Textarea::make('notes')
                    ->label('General Notes')
                    ->rows(2),

                // Lesson Completion Tracking (L1-L10) - Generated dynamically via trait
                ...self::generateLessonFields(10, [
                    1 => 'Lesson 1: Salvation',
                    2 => 'Lesson 2: Repentance',
                    3 => 'Lesson 3: Lordship',
                    4 => 'Lesson 4: Forgiveness',
                    5 => 'Lesson 5: LifeStyle',
                    6 => 'Lesson 6: Devotional Life',
                    7 => 'Lesson 7: Prayer',
                    8 => 'Lesson 8: Witnessing',
                    9 => 'Lesson 9: Life of Obedience',
                    10 => 'Lesson 10: Life in the Church',
                ]),
            ]);
    }
}
