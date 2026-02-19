<?php

namespace Database\Seeders;

use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    public function run(): void
    {
        $baseItemTypes = [
            'General',
            'Boardgame',
            'Videogame',
            'DVD',
            'CD',
            'Book'
        ];

        foreach ($baseItemTypes as $itemTypeName) {
            $itemType = new ItemType();
            $itemType->name = $itemTypeName;
            $itemType->save();
        }
    }
}
