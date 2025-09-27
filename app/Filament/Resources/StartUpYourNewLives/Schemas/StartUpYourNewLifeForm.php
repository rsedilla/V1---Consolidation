<?php

namespace App\Filament\Resources\StartUpYourNewLives\Schemas;

use App\Models\Member;
use App\Filament\Traits\HasMemberFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class StartUpYourNewLifeForm
{
    use HasMemberFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberField(),
                
                Textarea::make('notes')
                    ->label('General Notes')
                    ->rows(2),

                // Lesson Completion Tracking
                DatePicker::make('lesson_1_completion_date')
                    ->label('Lesson 1: Salvation'),
                DatePicker::make('lesson_2_completion_date')
                    ->label('Lesson 2: Repentance'),
                DatePicker::make('lesson_3_completion_date')
                    ->label('Lesson 3: Lordship'),
                DatePicker::make('lesson_4_completion_date')
                    ->label('Lesson 4: Forgiveness'),
                DatePicker::make('lesson_5_completion_date')
                    ->label('Lesson 5: LifeStyle'),
                DatePicker::make('lesson_6_completion_date')
                    ->label('Lesson 6: Devotional Life'),
                DatePicker::make('lesson_7_completion_date')
                    ->label('Lesson 7: Prayer'),
                DatePicker::make('lesson_8_completion_date')
                    ->label('Lesson 8: Witnessing'),
                DatePicker::make('lesson_9_completion_date')
                    ->label('Lesson 9: Life of Obedience'),
                DatePicker::make('lesson_10_completion_date')
                    ->label('Lesson 10: Life in the Church'),
            ]);
    }
}
