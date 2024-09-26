<?php

namespace Database\Seeders;

use App\Models\PopupLayoutType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopupLayoutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopupLayoutType::create(['name' => 'Full Screen Overlay']);
        PopupLayoutType::create(['name' => 'Slide-In Popup']);
        PopupLayoutType::create(['name' => 'Exit-Intent Popup']);
    }
}
