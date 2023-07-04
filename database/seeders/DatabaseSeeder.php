<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** @var User $adminUser */

//         Post::factory(30)->create();
        $adminUser = User::factory()->create([
                 'name' => 'Admin User',
                 'email' => 'admin@example.com',
                 'password' => bcrypt('admin@example.com')
        ]);
        $adminRole = Role::create(['name' => 'admin']);

        $adminUser->assignRole($adminRole);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
