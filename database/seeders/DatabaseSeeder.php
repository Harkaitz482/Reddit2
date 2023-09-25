<?php

namespace Database\Seeders;
// importar comunnity link
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CommunityLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

 

class DatabaseSeeder extends Seeder
{
    /**
     * 
     * Seed the application's database.
     */
    
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        DB::delete('delete from community_links');
        CommunityLink::factory()->count(50)->create(); 
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    
}
