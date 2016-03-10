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
        // $this->call(CompanyTableSeeder::class);
        // $this->call(CompanyTypeTableSeeder::class);
        // $this->call(KeypersonnelSeeder::class);
        // $this->call(ServiceSeeder::class);
        $this->call(CountrySeeder::class);


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

/**
* 
*/
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        DB::table('countries')->insert([
            ['name' => 'Afghanistan'],
            ['name' => 'Albania'],
            ['name' => 'Algeria'],
            ['name' => 'American Samoa'],
            ['name' => 'Andorra'],
            ['name' => 'Angola'],
            ['name' => 'Anguilla'],
            ['name' => 'Antarctica'],
            ['name' => 'Antigua and Barbuda'],
            ['name' => 'Argentina'],
            ['name' => 'Armenia'],
            ['name' => 'Aruba'],
            ['name' => 'Australia'],
            ['name' => 'Austria'],
            ['name' => 'Azerbaijan'],
            ['name' => 'Bahamas'],
            ['name' => 'Bahrain'],
            ['name' => 'Bangladesh'],
            ['name' => 'Barbados'],
            ['name' => 'Belarus'],
            ['name' => 'Belgium'],
            ['name' => 'Belize'],
            ['name' => 'Benin'],
            ['name' => 'Bermuda'],
            ['name' => 'Bhutan'],
            ['name' => 'Bolivia'],
            ['name' => 'Bosnia and Herzegovina'],
            ['name' => 'Botswana'],
            ['name' => 'Bouvet Island'],
            ['name' => 'Brazil'],
            ['name' => 'British Indian Ocean Territory'],
            ['name' => 'Brunei Darussalam'],
            ['name' => 'Bulgaria'],
            ['name' => 'Burkina Faso'],
            ['name' => 'Burundi'],
            ['name' => 'Cambodia'],
            ['name' => 'Cameroon'],
            ['name' => 'Canada'],
            ['name' => 'Cape Verde'],
            ['name' => 'Cayman Islands'],
            ['name' => 'Central African Republic'],
            ['name' => 'Chad'],
            ['name' => 'Chile'],
            ['name' => 'China'],
            ['name' => 'Christmas Island'],
            ['name' => 'Cocos (Keeling) Islands'],
            ['name' => 'Colombia'],
            ['name' => 'Comoros'],
            ['name' => 'Congo'],
            ['name' => 'Cook Islands'],
            ['name' => 'Costa Rica'],
            ['name' => 'Croatia (Hrvatska)'],
            ['name' => 'Cuba'],
            ['name' => 'Cyprus'],
            ['name' => 'Czech Republic'],
            ['name' => 'Denmark'],
            ['name' => 'Djibouti'],
            ['name' => 'Dominica'],
            ['name' => 'Dominican Republic'],
            ['name' => 'East Timor'],
            ['name' => 'Ecuador'],
            ['name' => 'Egypt'],
            ['name' => 'El Salvador'],
            ['name' => 'Equatorial Guinea'],
            ['name' => 'Eritrea'],
            ['name' => 'Estonia'],
            ['name' => 'Ethiopia'],
            ['name' => 'Falkland Islands (Malvinas)'],
            ['name' => 'Faroe Islands'],
            ['name' => 'Fiji'],
            ['name' => 'Finland'],
            ['name' => 'France'],
            ['name' => 'France, Metropolitan'],
            ['name' => 'French Guiana'],
            ['name' => 'French Polynesia'],
            ['name' => 'French Southern Territories'],
            ['name' => 'Gabon'],
            ['name' => 'Gambia'],
            ['name' => 'Georgia'],
            ['name' => 'Germany'],
            ['name' => 'Ghana'],
            ['name' => 'Gibraltar'],
            ['name' => 'Guernsey'],
            ['name' => 'Greece'],
            ['name' => 'Greenland'],
            ['name' => 'Grenada'],
            ['name' => 'Guadeloupe'],
            ['name' => 'Guam'],
            ['name' => 'Guatemala'],
            ['name' => 'Guinea'],
            ['name' => 'Guinea-Bissau'],
            ['name' => 'Guyana'],
            ['name' => 'Haiti'],
            ['name' => 'Heard and Mc Donald Islands'],
            ['name' => 'Honduras'],
            ['name' => 'Hong Kong'],
            ['name' => 'Hungary'],
            ['name' => 'Iceland'],
            ['name' => 'India'],
            ['name' => 'Isle of Man'],
            ['name' => 'Indonesia'],
            ['name' => 'Iran (Islamic Republic of)'],
            ['name' => 'Iraq'],
            ['name' => 'Ireland'],
            ['name' => 'Israel'],
            ['name' => 'Italy'],
            ['name' => 'Ivory Coast'],
            ['name' => 'Jersey'],
            ['name' => 'Jamaica'],
            ['name' => 'Japan'],
            ['name' => 'Jordan'],
            ['name' => 'Kazakhstan'],
            ['name' => 'Kenya'],
            ['name' => 'Kiribati'],
            ['name' => 'Korea, Democratic People`s Republic of'],
            ['name' => 'Korea, Republic of'],
            ['name' => 'Kosovo'],
            ['name' => 'Kuwait'],
            ['name' => 'Kyrgyzstan'],
            ['name' => 'Lao People`s Democratic Republic'],
            ['name' => 'Latvia'],
            ['name' => 'Lebanon'],
            ['name' => 'Lesotho'],
            ['name' => 'Liberia'],
            ['name' => 'Libyan Arab Jamahiriya'],
            ['name' => 'Liechtenstein'],
            ['name' => 'Lithuania'],
            ['name' => 'Luxembourg'],
            ['name' => 'Macau'],
            ['name' => 'Macedonia'],
            ['name' => 'Madagascar'],
            ['name' => 'Malawi'],
            ['name' => 'Malaysia'],
            ['name' => 'Maldives'],
            ['name' => 'Mali'],
            ['name' => 'Malta'],
            ['name' => 'Marshall Islands'],
            ['name' => 'Martinique'],
            ['name' => 'Mauritania'],
            ['name' => 'Mauritius'],
            ['name' => 'Mayotte'],
            ['name' => 'Mexico'],
            ['name' => 'Micronesia, Federated States of'],
            ['name' => 'Moldova, Republic of'],
            ['name' => 'Monaco'],
            ['name' => 'Mongolia'],
            ['name' => 'Montenegro'],
            ['name' => 'Montserrat'],
            ['name' => 'Morocco'],
            ['name' => 'Mozambique'],
            ['name' => 'Myanmar'],
            ['name' => 'Namibia'],
            ['name' => 'Nauru'],
            ['name' => 'Nepal'],
            ['name' => 'Netherlands'],
            ['name' => 'Netherlands Antilles'],
            ['name' => 'New Caledonia'],
            ['name' => 'New Zealand'],
            ['name' => 'Nicaragua'],
            ['name' => 'Niger'],
            ['name' => 'Nigeria'],
            ['name' => 'Niue'],
            ['name' => 'Norfolk Island'],
            ['name' => 'Northern Mariana Islands'],
            ['name' => 'Norway'],
            ['name' => 'Oman'],
            ['name' => 'Pakistan'],
            ['name' => 'Palau'],
            ['name' => 'Palestine'],
            ['name' => 'Panama'],
            ['name' => 'Papua New Guinea'],
            ['name' => 'Paraguay'],
            ['name' => 'Peru'],
            ['name' => 'Philippines'],
            ['name' => 'Pitcairn'],
            ['name' => 'Poland'],
            ['name' => 'Portugal'],
            ['name' => 'Puerto Rico'],
            ['name' => 'Qatar'],
            ['name' => 'Reunion'],
            ['name' => 'Romania'],
            ['name' => 'Russian Federation'],
            ['name' => 'Rwanda'],
            ['name' => 'Saint Kitts and Nevis'],
            ['name' => 'Saint Lucia'],
            ['name' => 'Saint Vincent and the Grenadines'],
            ['name' => 'Samoa'],
            ['name' => 'San Marino'],
            ['name' => 'Sao Tome and Principe'],
            ['name' => 'Saudi Arabia'],
            ['name' => 'Senegal'],
            ['name' => 'Serbia'],
            ['name' => 'Seychelles'],
            ['name' => 'Sierra Leone'],
            ['name' => 'Singapore'],
            ['name' => 'Slovakia'],
            ['name' => 'Slovenia'],
            ['name' => 'Solomon Islands'],
            ['name' => 'Somalia'],
            ['name' => 'South Africa'],
            ['name' => 'South Georgia South Sandwich Islands'],
            ['name' => 'Spain'],
            ['name' => 'Sri Lanka'],
            ['name' => 'St. Helena'],
            ['name' => 'St. Pierre and Miquelon'],
            ['name' => 'Sudan'],
            ['name' => 'Suriname'],
            ['name' => 'Svalbard and Jan Mayen Islands'],
            ['name' => 'Swaziland'],
            ['name' => 'Sweden'],
            ['name' => 'Switzerland'],
            ['name' => 'Syrian Arab Republic'],
            ['name' => 'Taiwan'],
            ['name' => 'Tajikistan'],
            ['name' => 'Tanzania, United Republic of'],
            ['name' => 'Thailand'],
            ['name' => 'Togo'],
            ['name' => 'Tokelau'],
            ['name' => 'Tonga'],
            ['name' => 'Trinidad and Tobago'],
            ['name' => 'Tunisia'],
            ['name' => 'Turkey'],
            ['name' => 'Turkmenistan'],
            ['name' => 'Turks and Caicos Islands'],
            ['name' => 'Tuvalu'],
            ['name' => 'Uganda'],
            ['name' => 'Ukraine'],
            ['name' => 'United Arab Emirates'],
            ['name' => 'United Kingdom'],
            ['name' => 'United States'],
            ['name' => 'United States minor outlying islands'],
            ['name' => 'Uruguay'],
            ['name' => 'Uzbekistan'],
            ['name' => 'Vanuatu'],
            ['name' => 'Vatican City State'],
            ['name' => 'Venezuela'],
            ['name' => 'Vietnam'],
            ['name' => 'Virgin Islands (British)'],
            ['name' => 'Virgin Islands (U.S.)'],
            ['name' => 'Wallis and Futuna Islands'],
            ['name' => 'Western Sahara'],
            ['name' => 'Yemen'],
            ['name' => 'Yugoslavia'],
            ['name' => 'Zaire'],
            ['name' => 'Zambia'],
            ['name' => 'Zimbabwe']
        ]);
    }
}