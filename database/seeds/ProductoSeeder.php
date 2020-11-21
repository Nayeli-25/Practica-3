<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Productos::class, 120)->create();
    }
}


        
    /**DB::table('productos')->insert([
        'Producto' => 'Laptop Microsoft Surface Go'
    ]); **/
