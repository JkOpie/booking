<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $admin = User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => Hash::make('12345678')
        ]);

        $user = User::create([
            'email' => 'user@gmail.com',
            'name' => 'user',
            'password' => Hash::make('12345678')
        ]);

        $admin->assignRole('admin');
        $user->assignRole('user');

        $typeData = [
            ["Sports Facilities", "We offers wide range of first-class facilities and aminities for sports"],
            ["Multipurpose Hall", "We offers a location for a great and prestigious event"]
        ];

        $categoriesData = [
            "Batminton Court",
            "Fusal Court",
            "Tennis Court",
            "Ping Pong",
            'Wedding',
            'Tournament',
            'Conference',
            'Exibition',
        ];

        $items = [
            ['Sri Rampai Batminton Court', 'The best batminton court in malaysia', '1', '1'],
            ['Petaling Jaya Futsal', 'The best Futsal court in malaysia', '1','2' ],
            ['Long Chai Tennis Court', 'The best Tennis court in malaysia', '1' , '3'],
            ['Ping Pong House Gombak', 'The best Ping Pong in malaysia', '1', '4'],
            ['Dewan Kawin Salak', 'The best Wedding Hall in Malaysia', '2','5'],
            ['Tournament Hall Seremban', 'The best tournament hall in seremban','2', '6'],
            ['Conference Hall Kajang', 'The Best Conference Hall in Kajang', '2', '7'],
            ['Exibition Hall Klang', 'The Best Exibition Hall in Klang', '2', '8']
        ];

        foreach ($typeData as $key => $value) {
            Type::firstOrCreate([
                'name' => $value[0],
                'description' => $value[1]
            ]);
        }

        foreach ($categoriesData as $key => $value) {
            //dd($value);
            Category::firstOrCreate([
                'name' => $value
            ]);
        }

        foreach ($items as $key => $value) {
            //dd($value[0]);
            Item::create([
                'name' => $value[0],
                'description'=> $value[1],
                'type_id'=> $value[2],
                'category_id' => $value[3],
                'status' => 'available'
            ]);
        }

    }
}
