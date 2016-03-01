<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UserTableSeeder::class);                
        $this->call(CompanyTableSeeder::class);
        $this->call(CompanyTypeTableSeeder::class);
        $this->call(KeypersonnelSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(JurisdictionsSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
		    [
	        	'name' => 'admin',
	        	'email' => 'zaw@manic.com.sg',
	        	'password' => Hash::make( 'p@ssword' )        	
        	]
		]);        
    }
}

class CompanyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_types')->delete();

        DB::table('company_types')->insert([
            [
                'name' => 'Cyprus limited liability company'                
            ],
            [
                'name' => 'Mauritius Class 1 company'
            ],
            [
                'name' => 'Cyprus branch of a UK company'
            ],
            [
                'name' => 'Mauritius Class 1 company'
            ],
            [
                'name' => 'Mauritius Class 2 company'
            ]
        ]);        
    }
}

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        DB::table('companies')->insert([
            [
                'name' => 'company 1',
                'incoporation_date' => \Carbon\Carbon::createFromDate(2015,07,22)->toDateTimeString(),
                'price' => '30000',         
                'shelf' => true,       
                'company_type_id' => 1     
            ],
            [
                'name' => 'company 2',
                'incoporation_date' => \Carbon\Carbon::createFromDate(2014,07,22)->toDateTimeString(),
                'price' => '40000', 
                'shelf' => true,
                'company_type_id' => 2
            ],
            [
                'name' => 'company 3',
                'incoporation_date' => \Carbon\Carbon::createFromDate(2013,07,22)->toDateTimeString(),
                'price' => '50000', 
                'shelf' => true,
                'company_type_id' => 3
            ],
            [
                'name' => 'new company',
                'incoporation_date' => \Carbon\Carbon::createFromDate(2012,07,22)->toDateTimeString(),
                'price' => '60000', 
                'shelf' => false,
                'company_type_id' => 4
            ]
        ]);        
    }
}

class KeypersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('keypersonnel')->delete();

        DB::table('keypersonnel')->insert([
            [
                'name' => 'key personnel 1',                
                'price' => '2000',         
                'offshore' => true,                
                'role' => 'director'                
            ],
            [
                'name' => 'key personnel 2',                
                'price' => '3000',         
                'offshore' => true,                
                'role' => 'shareholder'
            ],
            [
                'name' => 'key personnel 3',                
                'price' => '4000',         
                'offshore' => true,                
                'role' => 'secretary'
            ],
            [
                'name' => 'key personnel 4',                
                'price' => '5000',         
                'offshore' => true,                
                'role' => 'director'
            ]
        ]);        
    }
}


class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->delete();

        DB::table('services')->insert([
            [
                'name' => 'service 1',                
                'price' => '2000'                
            ],
            [
                'name' => 'service 2',                
                'price' => '3000'
            ],
            [
                'name' => 'service 3',                
                'price' => '4000'
            ],
            [
                'name' => 'service 4',                
                'price' => '5000'
            ]
        ]);        
    }
}

class JurisdictionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurisdictions')->delete();

        DB::table('jurisdictions')->insert([
            [
                'name' => 'service 1',                
                'price' => '2000'                
            ],
            [
                'name' => 'service 2',                
                'price' => '3000'
            ],
            [
                'name' => 'service 3',                
                'price' => '4000'
            ],
            [
                'name' => 'service 4',                
                'price' => '5000'
            ]
        ]);        
    }
}