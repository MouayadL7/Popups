<?php

namespace Database\Seeders;

use App\Models\PopupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopupType::create(['name' => 'Promotional Offer']);
        PopupType::create(['name' => 'Newsletter Signup']);
        PopupType::create(['name' => 'Social Media Link']);
    }
}
