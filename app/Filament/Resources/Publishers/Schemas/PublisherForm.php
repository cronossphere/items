<?php


namespace App\Filament\Resources\Publishers\Schemas;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PublisherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('website')->url()->maxLength(255),
            TextInput::make('country')->label('Country (ISO-2)')->maxLength(2),
            Textarea::make('notes')->rows(6)->columnSpanFull(),

            Select::make('scopes_list')
                ->label('Gültig für')
                ->multiple()
                ->options([
                    'book' => 'Books',
                    'movie' => 'Movies',
                    'game' => 'Games',
                ])
                ->dehydrated(false)
        ]);
    }
}
