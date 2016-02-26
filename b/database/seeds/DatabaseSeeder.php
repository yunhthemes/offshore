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
        $this->call(SecretarySeeder::class);
        $this->call(DirectorSeeder::class);
        $this->call(ShareholderSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(CompanyDirectorSeeder::class);

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

class SecretarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secretaries')->delete();

        DB::table('secretaries')->insert([
            [
                'name' => 'secretary 1',                
                'price' => '2000',         
                'offshore' => true                
            ],
            [
                'name' => 'secretary 2',                
                'price' => '3000',         
                'offshore' => true
            ],
            [
                'name' => 'secretary 3',                
                'price' => '4000',         
                'offshore' => true
            ],
            [
                'name' => 'secretary 4',                
                'price' => '5000',         
                'offshore' => true
            ]
        ]);        
    }
}

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directors')->delete();

        DB::table('directors')->insert([
            [
                'name' => 'director 1',                
                'price' => '2000',         
                'offshore' => true                
            ],
            [
                'name' => 'director 2',                
                'price' => '3000',         
                'offshore' => true
            ],
            [
                'name' => 'director 3',                
                'price' => '4000',         
                'offshore' => true
            ],
            [
                'name' => 'director 4',                
                'price' => '5000',         
                'offshore' => true
            ]
        ]);        
    }
}

class ShareholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shareholders')->delete();

        DB::table('shareholders')->insert([
            [
                'name' => 'shareholder 1',                
                'price' => '2000',         
                'offshore' => true                
            ],
            [
                'name' => 'shareholder 2',                
                'price' => '3000',         
                'offshore' => true
            ],
            [
                'name' => 'shareholder 3',                
                'price' => '4000',         
                'offshore' => true
            ],
            [
                'name' => 'shareholder 4',                
                'price' => '5000',         
                'offshore' => true
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

class CompanyDirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_director')->delete();

        DB::table('company_director')->insert([
            [
                'company_id' => '45',                
                'director_id' => '29',
                'passport' => '12345',
                'utility_bill' => '54321'
            ],
            [
                'company_id' => '45',                
                'director_id' => '36',
                'passport' => '12345',
                'utility_bill' => '54321'
            ],
            [
                'company_id' => '46',                
                'director_id' => '36',
                'passport' => '12345',
                'utility_bill' => '54321'      
            ],
            [
                'company_id' => '46',                
                'director_id' => '31',
                'passport' => '12345',
                'utility_bill' => '54321'        
            ]
        ]);        
    }
}