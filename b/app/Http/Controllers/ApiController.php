<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\CompanyType;
use App\CompanyWpuser;
use App\CompanyWpuserShareholder;
use App\CompanyWpuserDirector;
use App\CompanyWpuserSecretary;
use App\CompanyWpuserServiceCountry;
use App\CompanyWpuserInformationService;
use App\Wpuser;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Person;
use App\WpuserLoginLog;
use App\WpBpXprofileFields;
use App\WpBpXprofileData;
use App\TransactionLog;
use Excel;

class ApiController extends Controller
{
    //
    public function companytype($id) {
    	
  		$company_types = CompanyType::find($id);

  		if($company_types) {
  			$company_types->companies;
  			return $company_types;
  		}else
  			return response()->json(['message' => 'no resource was found'], 404);
    		
    }

    public function updateuserunavailablecompainesdeletestatus($id) {
        $company_wpuser = CompanyWpuser::find($id);
        $company_wpuser->return = 1;
        $company_wpuser->save();
    }

    public function removeusercompanies($id, Request $request) {

        $wpuser_id = $request->user_id;
        $company_id = $request->company_id;

        $company_wpuser_shareholder = CompanyWpuserShareholder::where("companywpuser_id", $id);
        if($company_wpuser_shareholder) $company_wpuser_shareholder->delete();

        $company_wpuser_director = CompanyWpuserDirector::where("companywpuser_id", $id);
        if($company_wpuser_director) $company_wpuser_director->delete();

        $company_wpuser_secretary = CompanyWpuserSecretary::where("companywpuser_id", $id);
        if($company_wpuser_secretary) $company_wpuser_secretary->delete();

        $company_wpuser_service_country = CompanyWpuserServiceCountry::where("companywpuser_id", $id);
        if($company_wpuser_service_country) $company_wpuser_service_country->delete();

        $company_wpuser_information_service = CompanyWpuserInformationService::where("companywpuser_id", $id);
        if($company_wpuser_information_service) $company_wpuser_information_service->delete();

        $company_wpuser = CompanyWpuser::find($id);        
        if($company_wpuser) $affectedRows = $company_wpuser->delete();

        if($affectedRows) {
            return response()->json(['message' => 'Successfully deleted'], 200);    
        }else {
            return response()->json(['message' => 'Request failed', 'error' => $error], 412);    
        }

    }

    public function usercompanies($id, Request $request) {

        // $wpuser_compaines = Company::with("companytypes")->where('wpuser_id', $id)->get();         

        $wpuser_companies = Wpuser::find($id)->companies()->with(["wpusers" => function($query) use($id) {
            $query->select("user_nicename", "user_login")->where('wpuser_id', $id);
        }, "companytypes"])->get();

        // return $wpuser_companies;

        foreach ($wpuser_companies as $key => $wpuser_company) {
            $company_id = $wpuser_company->id;
            $owner = false;
            $return = false;

            if($wpuser_company->status==1) {
              // if company is bought, check whether its this user's company
              $wpuser_companies_status = CompanyWpuser::where('company_id', $company_id)->where('wpuser_id', $id)->where('status', 2)->get();
              $wpuser_companies_return = CompanyWpuser::where('company_id', $company_id)->where('wpuser_id', $id)->where('return', 1)->get();

              if(count($wpuser_companies_status)>0) $owner = true;
              if(count($wpuser_companies_return)>0) $return = true;
            }            

            $wpuser_company->owner = $owner;
            $wpuser_company->return = $return;
            $wpuser_company->incorporation_date = date('d M Y', strtotime($wpuser_company->incorporation_date));
            $wpuser_company->wpusers[0]->pivot->renewal_date = date('d M Y', strtotime($wpuser_company->wpusers[0]->pivot->renewal_date));
        }

    	if(empty($wpuser_companies)) {		
    		return response()->json(['message' => 'user not found'], 202)->setCallback($request->input('callback'));
    	}
        
        return response()->json(['message' => 'Success', 'companies' => $wpuser_companies], 200)->setCallback($request->input('callback'));

    }

    public function usercompanydetails($id, $user_id, Request $request) {

        // $wpuser_company_details = Company::with(['companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice', 'wpusers' => function($query) use($user_id) {
        //     $query->select("user_nicename")->where('wpuser_id', $user_id);
        //   }])->get()->find($id);

        $companies = Company::with(['companytypes'])->where('id', $id)->get();
        $wpusers = Wpuser::where('ID', $user_id)->first(['user_nicename']);

        $wpuser_company_details = CompanyWpuser::with(['companywpuser_shareholders', 'companywpuser_directors', 'companywpuser_secretaries', 'servicescountries', 'informationservices'])->where('wpuser_id', $user_id)->where('company_id', $id)->first();

        if($wpuser_company_details) {
          $wpuser_company_details['companies'] = $companies;
          $wpuser_company_details['wpusers'] = $wpusers;

          $wpuser_company_details->renewal_date = date('d M Y', strtotime($wpuser_company_details->renewal_date));
          $wpuser_company_details->companies[0]->incorporation_date = date('d M Y', strtotime($wpuser_company_details->companies[0]->incorporation_date));

          return response()->json(['message' => 'Success', 'companydetails' => $wpuser_company_details], 200)->setCallback($request->input('callback'));
        }                

        return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));                

    }

    public function uploadfiles(Request $request) {

        // $type = $request->type;

        $user_name = $request->user_name;

        if ($request->hasFile('files')) {
            $file = $request->file('files');   
            $destinationPath = public_path() . "/uploads/" . $user_name . "/";

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $orgFilename     = $file->getClientOriginalName();
            $filename        = $file->getClientOriginalName();
            $uploadSuccess   = $file->move($destinationPath, $filename);
        }

        if(!empty($uploadSuccess)) {
            error_log("Destination: $destinationPath");
            error_log("Filename: $filename");
            error_log("Extension: ".$file->getClientOriginalExtension());
            error_log("Original name: ".$file->getClientOriginalName());
            error_log("Real path: ".$file->getRealPath());
            return response()->json([
                "file" => [
                    "name" => $filename,
                    "org_name" => $orgFilename,
                    "destinationPath" => $destinationPath              
                ]
            ]);

            // return $filename . '||' . $orgFilename . '||' . $destinationPath;
        }
        else {
            error_log("Error moving file: ".$file->getClientOriginalName());
            return 'Erorr on ';
        }          

    }

    public function retrievesavedcompany(Request $request) {
        
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        // $wpuser_companies = Company::with(['companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice', 'wpusers' => function($query) use($user_id) {
        //   $query->select('user_nicename')->where('wpuser_id', $user_id);
        // }])->where('id', $company_id)->where('status', 0)->get();

        // return $wpuser_companies;

        $companies = Company::with(['companytypes'])->where('id', $company_id)->get();
        $wpusers = Wpuser::where('ID', $user_id)->first(['user_nicename']);

        $wpuser_companies = CompanyWpuser::with(['companywpuser_shareholders', 'companywpuser_directors', 'companywpuser_secretaries', 'servicescountries', 'informationservices'])->where('wpuser_id', $user_id)->where('company_id', $company_id)->first();

        $wpuser_companies['companies'] = $companies;
        $wpuser_companies['wpusers'] = $wpusers;

        // return $wpuser_companies;

        // $wpuser_companies = Company::with(['wpusers' => function($query) use($user_id) {
        //   $query->join('companywpuser_shareholders', 'company_wpusers.id', '=', 'companywpuser_shareholders.companywpuser_id')                
        //         ->join('companywpuser_service_country', 'company_wpusers.id', '=', 'companywpuser_service_country.companywpuser_id')
        //         ->select('companywpuser_shareholders.*', 'companywpuser_service_country.*')                
        //         ->where('wpuser_id', $user_id);
        // }])->where('id', $company_id)->get();

        // $wpuser_companies = Company::find($company_id)->with(['wpusers' => function($query) use($user_id){
        //   $query->select('user_nicename')->where('wpuser_id', $user_id);
        // }])->get();

        if(empty($wpuser_companies)) {      
            return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));
        }
        
        return response()->json(['message' => 'Success', 'saved_data' => $wpuser_companies], 200);

    }

    public function gettimezonelist($country, $city) {

        $country_codes = array (
          'AF' => 'Afghanistan',
          'AX' => 'Åland Islands',
          'AL' => 'Albania',
          'DZ' => 'Algeria',
          'AS' => 'American Samoa',
          'AD' => 'Andorra',
          'AO' => 'Angola',
          'AI' => 'Anguilla',
          'AQ' => 'Antarctica',
          'AG' => 'Antigua and Barbuda',
          'AR' => 'Argentina',
          'AU' => 'Australia',
          'AT' => 'Austria',
          'AZ' => 'Azerbaijan',
          'BS' => 'Bahamas',
          'BH' => 'Bahrain',
          'BD' => 'Bangladesh',
          'BB' => 'Barbados',
          'BY' => 'Belarus',
          'BE' => 'Belgium',
          'BZ' => 'Belize',
          'BJ' => 'Benin',
          'BM' => 'Bermuda',
          'BT' => 'Bhutan',
          'BO' => 'Bolivia',
          'BA' => 'Bosnia and Herzegovina',
          'BW' => 'Botswana',
          'BV' => 'Bouvet Island',
          'BR' => 'Brazil',
          'IO' => 'British Indian Ocean Territory',
          'BN' => 'Brunei Darussalam',
          'BG' => 'Bulgaria',
          'BF' => 'Burkina Faso',
          'BI' => 'Burundi',
          'KH' => 'Cambodia',
          'CM' => 'Cameroon',
          'CA' => 'Canada',
          'CV' => 'Cape Verde',
          'KY' => 'Cayman Islands',
          'CF' => 'Central African Republic',
          'TD' => 'Chad',
          'CL' => 'Chile',
          'CN' => 'China',
          'CX' => 'Christmas Island',
          'CC' => 'Cocos (Keeling) Islands',
          'CO' => 'Colombia',
          'KM' => 'Comoros',
          'CG' => 'Congo',
          'CD' => 'Zaire',
          'CK' => 'Cook Islands',
          'CR' => 'Costa Rica',
          'CI' => 'Côte D\'Ivoire',
          'HR' => 'Croatia',
          'CU' => 'Cuba',
          'CY' => 'Cyprus',
          'CZ' => 'Czech Republic',
          'DK' => 'Denmark',
          'DJ' => 'Djibouti',
          'DM' => 'Dominica',
          'DO' => 'Dominican Republic',
          'EC' => 'Ecuador',
          'EG' => 'Egypt',
          'SV' => 'El Salvador',
          'GQ' => 'Equatorial Guinea',
          'ER' => 'Eritrea',
          'EE' => 'Estonia',
          'ET' => 'Ethiopia',
          'FK' => 'Falkland Islands (Malvinas)',
          'FO' => 'Faroe Islands',
          'FJ' => 'Fiji',
          'FI' => 'Finland',
          'FR' => 'France',
          'GF' => 'French Guiana',
          'PF' => 'French Polynesia',
          'TF' => 'French Southern Territories',
          'GA' => 'Gabon',
          'GM' => 'Gambia',
          'GE' => 'Georgia',
          'DE' => 'Germany',
          'GH' => 'Ghana',
          'GI' => 'Gibraltar',
          'GR' => 'Greece',
          'GL' => 'Greenland',
          'GD' => 'Grenada',
          'GP' => 'Guadeloupe',
          'GU' => 'Guam',
          'GT' => 'Guatemala',
          'GG' => 'Guernsey',
          'GN' => 'Guinea',
          'GW' => 'Guinea-Bissau',
          'GY' => 'Guyana',
          'HT' => 'Haiti',
          'HM' => 'Heard Island and Mcdonald Islands',
          'VA' => 'Vatican City State',
          'HN' => 'Honduras',
          'HK' => 'Hong Kong',
          'HU' => 'Hungary',
          'IS' => 'Iceland',
          'IN' => 'India',
          'ID' => 'Indonesia',
          'IR' => 'Iran, Islamic Republic of',
          'IQ' => 'Iraq',
          'IE' => 'Ireland',
          'IM' => 'Isle of Man',
          'IL' => 'Israel',
          'IT' => 'Italy',
          'JM' => 'Jamaica',
          'JP' => 'Japan',
          'JE' => 'Jersey',
          'JO' => 'Jordan',
          'KZ' => 'Kazakhstan',
          'KE' => 'KENYA',
          'KI' => 'Kiribati',
          'KP' => 'Korea, Democratic People\'s Republic of',
          'KR' => 'Korea, Republic of',
          'KW' => 'Kuwait',
          'KG' => 'Kyrgyzstan',
          'LA' => 'Lao People\'s Democratic Republic',
          'LV' => 'Latvia',
          'LB' => 'Lebanon',
          'LS' => 'Lesotho',
          'LR' => 'Liberia',
          'LY' => 'Libyan Arab Jamahiriya',
          'LI' => 'Liechtenstein',
          'LT' => 'Lithuania',
          'LU' => 'Luxembourg',
          'MO' => 'Macao',
          'MK' => 'Macedonia, the Former Yugoslav Republic of',
          'MG' => 'Madagascar',
          'MW' => 'Malawi',
          'MY' => 'Malaysia',
          'MV' => 'Maldives',
          'ML' => 'Mali',
          'MT' => 'Malta',
          'MH' => 'Marshall Islands',
          'MQ' => 'Martinique',
          'MR' => 'Mauritania',
          'MU' => 'Mauritius',
          'YT' => 'Mayotte',
          'MX' => 'Mexico',
          'FM' => 'Micronesia, Federated States of',
          'MD' => 'Moldova, Republic of',
          'MC' => 'Monaco',
          'MN' => 'Mongolia',
          'ME' => 'Montenegro',
          'MS' => 'Montserrat',
          'MA' => 'Morocco',
          'MZ' => 'Mozambique',
          'MM' => 'Myanmar',
          'NA' => 'Namibia',
          'NR' => 'Nauru',
          'NP' => 'Nepal',
          'NL' => 'Netherlands',
          'AN' => 'Netherlands Antilles',
          'NC' => 'New Caledonia',
          'NZ' => 'New Zealand',
          'NI' => 'Nicaragua',
          'NE' => 'Niger',
          'NG' => 'Nigeria',
          'NU' => 'Niue',
          'NF' => 'Norfolk Island',
          'MP' => 'Northern Mariana Islands',
          'NO' => 'Norway',
          'OM' => 'Oman',
          'PK' => 'Pakistan',
          'PW' => 'Palau',
          'PS' => 'Palestinian Territory, Occupied',
          'PA' => 'Panama',
          'PG' => 'Papua New Guinea',
          'PY' => 'Paraguay',
          'PE' => 'Peru',
          'PH' => 'Philippines',
          'PN' => 'Pitcairn',
          'PL' => 'Poland',
          'PT' => 'Portugal',
          'PR' => 'Puerto Rico',
          'QA' => 'Qatar',
          'RE' => 'Réunion',
          'RO' => 'Romania',
          'RU' => 'Russian Federation',
          'RW' => 'Rwanda',
          'SH' => 'Saint Helena',
          'KN' => 'Saint Kitts and Nevis',
          'LC' => 'Saint Lucia',
          'PM' => 'Saint Pierre and Miquelon',
          'VC' => 'Saint Vincent and the Grenadines',
          'WS' => 'Samoa',
          'SM' => 'San Marino',
          'ST' => 'Sao Tome and Principe',
          'SA' => 'Saudi Arabia',
          'SN' => 'Senegal',
          'RS' => 'Serbia',
          'SC' => 'Seychelles',
          'SL' => 'Sierra Leone',
          'SG' => 'Singapore',
          'SK' => 'Slovakia',
          'SI' => 'Slovenia',
          'SB' => 'Solomon Islands',
          'SO' => 'Somalia',
          'ZA' => 'South Africa',
          'GS' => 'South Georgia and the South Sandwich Islands',
          'ES' => 'Spain',
          'LK' => 'Sri Lanka',
          'SD' => 'Sudan',
          'SR' => 'Suriname',
          'SJ' => 'Svalbard and Jan Mayen',
          'SZ' => 'Swaziland',
          'SE' => 'Sweden',
          'CH' => 'Switzerland',
          'SY' => 'Syrian Arab Republic',
          'TW' => 'Taiwan, Province of China',
          'TJ' => 'Tajikistan',
          'TZ' => 'Tanzania, United Republic of',
          'TH' => 'Thailand',
          'TL' => 'Timor-Leste',
          'TG' => 'Togo',
          'TK' => 'Tokelau',
          'TO' => 'Tonga',
          'TT' => 'Trinidad and Tobago',
          'TN' => 'Tunisia',
          'TR' => 'Turkey',
          'TM' => 'Turkmenistan',
          'TC' => 'Turks and Caicos Islands',
          'TV' => 'Tuvalu',
          'UG' => 'Uganda',
          'UA' => 'Ukraine',
          'AE' => 'United Arab Emirates',
          'GB' => 'United Kingdom',
          'US' => 'United States',
          'UM' => 'United States Minor Outlying Islands',
          'UY' => 'Uruguay',
          'UZ' => 'Uzbekistan',
          'VU' => 'Vanuatu',
          'VE' => 'Venezuela',
          'VN' => 'Viet Nam',
          'VG' => 'Virgin Islands, British',
          'VI' => 'Virgin Islands, U.S.',
          'WF' => 'Wallis and Futuna',
          'EH' => 'Western Sahara',
          'YE' => 'Yemen',
          'ZM' => 'Zambia',
          'ZW' => 'Zimbabwe',
        );

        $country_code = array_search(strtolower($country), array_map('strtolower', $country_codes));

        $timezone = timezone_identifiers_list(4096, $country_code);
        $timezonestr = $timezone[0];
        date_default_timezone_set($timezonestr);

        if($city && (!empty($city) && $city!=="none")) $name = $city;
        else $name = $country;

        $date= "Present time in ".$name.": ". date('D, d M Y H:i') . " hrs";

        return $date;
    }

    public function addusertopersondb(Request $request) {
        
        $wpuser_id = $request->wpuser_id;

        $wpuserloginlog = WpuserLoginLog::where('uid', $wpuser_id)->orderBy('time', 'DESC')->first();

        $wpuser = Wpuser::find($wpuser_id);

        $fields = WpBpXprofileFields::select('id', 'name')->get();

        foreach ($fields as $key => $field) {
            if($field->name == "Person code") $person_code_field_id = $field->id;
            if($field->name == "Person type") $person_type_field_id = $field->id;
            if($field->name == "Title") $title_field_id = $field->id;
            if($field->name == "First name") $first_name_field_id = $field->id;
            if($field->name == "Surname") $surname_field_id = $field->id;            
            if($field->name == "Nationality") $nationality_field_id = $field->id;
            if($field->name == "Passport no") $passport_no_field_id = $field->id;
            if($field->name == "Passport expiry") $passport_expiry_field_id = $field->id;
            if($field->name == "Tax residence") $tax_residence_field_id = $field->id;
            if($field->name == "Tax number") $tax_number_field_id = $field->id;
            if($field->name == "Mobile telephone") $mobile_telephone_field_id = $field->id;
            if($field->name == "Work telephone") $work_telephone_field_id = $field->id;
            if($field->name == "Home telephone") $home_telephone_field_id = $field->id;
            if($field->name == "Home address") $home_address_field_id = $field->id;
            if($field->name == "Home address 2") $home_address_2_field_id = $field->id;
            if($field->name == "Home address 3") $home_address_3_field_id = $field->id;
            if($field->name == "Home address 6") $home_address_6_field_id = $field->id;
            if($field->name == "Home address 5") $home_address_5_field_id = $field->id;
            if($field->name == "Postal address") $postal_address_field_id = $field->id;
            if($field->name == "Postal address 2") $postal_address_2_field_id = $field->id;
            if($field->name == "Postal address 3") $postal_address_3_field_id = $field->id;
            if($field->name == "Postal address 6") $postal_address_6_field_id = $field->id;
            if($field->name == "Postal address 5") $postal_address_5_field_id = $field->id;            
            if($field->name == "Preferred currency") $preferred_currency_field_id = $field->id;            
            if($field->name == "Relationship commenced") $relationship_commenced_field_id = $field->id;
            if($field->name == "Relationship ended") $relationship_ended_field_id = $field->id;
            if($field->name == "Passport copy") $passport_copy_field_id = $field->id;
            if($field->name == "Proof of address") $proof_of_address_field_id = $field->id;
            if($field->name == "Bank reference") $bank_reference_field_id = $field->id;
            if($field->name == "Professional reference") $professional_reference_field_id = $field->id;
            if($field->name == "Notes") $notes_field_id = $field->id;
        }

        if(isset($person_code_field_id)) $person_code = WpBpXprofileData::where("field_id", $person_code_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($person_type_field_id)) $person_type = WpBpXprofileData::where("field_id", $person_type_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($title_field_id)) $title =  WpBpXprofileData::where("field_id", $title_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($first_name_field_id)) $first_name =  WpBpXprofileData::where("field_id", $first_name_field_id)->where("user_id", $wpuser_id)->first(); 
        if(isset($surname_field_id)) $surname =  WpBpXprofileData::where("field_id", $surname_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($nationality_field_id)) $nationality =  WpBpXprofileData::where("field_id", $nationality_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($passport_no_field_id)) $passport_no =  WpBpXprofileData::where("field_id", $passport_no_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($passport_expiry_field_id)) $passport_expiry =  WpBpXprofileData::where("field_id", $passport_expiry_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($tax_residence_field_id)) $tax_residence =  WpBpXprofileData::where("field_id", $tax_residence_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($tax_number_field_id)) $tax_number =  WpBpXprofileData::where("field_id", $tax_number_field_id)->where("user_id", $wpuser_id)->first();        
        if(isset($mobile_telephone_field_id)) $mobile_telephone =  WpBpXprofileData::where("field_id", $mobile_telephone_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($work_telephone_field_id)) $work_telephone =  WpBpXprofileData::where("field_id", $work_telephone_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_telephone_field_id)) $home_telephone =  WpBpXprofileData::where("field_id", $home_telephone_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_address_field_id)) $home_address =  WpBpXprofileData::where("field_id", $home_address_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_address_2_field_id)) $home_address_2 =  WpBpXprofileData::where("field_id", $home_address_2_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_address_3_field_id)) $home_address_3 =  WpBpXprofileData::where("field_id", $home_address_3_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_address_6_field_id)) $home_address_6 =  WpBpXprofileData::where("field_id", $home_address_6_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($home_address_5_field_id)) $home_address_5 =  WpBpXprofileData::where("field_id", $home_address_5_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($postal_address_field_id)) $postal_address =  WpBpXprofileData::where("field_id", $postal_address_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($postal_address_2_field_id)) $postal_address_2 =  WpBpXprofileData::where("field_id", $postal_address_2_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($postal_address_3_field_id)) $postal_address_3 =  WpBpXprofileData::where("field_id", $postal_address_3_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($postal_address_6_field_id)) $postal_address_6 =  WpBpXprofileData::where("field_id", $postal_address_6_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($postal_address_5_field_id)) $postal_address_5 =  WpBpXprofileData::where("field_id", $postal_address_5_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($preferred_currency_field_id)) $preferred_currency =  WpBpXprofileData::where("field_id", $preferred_currency_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($relationship_commenced_field_id)) $relationship_commenced =  WpBpXprofileData::where("field_id", $relationship_commenced_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($relationship_ended_field_id)) $relationship_ended =  WpBpXprofileData::where("field_id", $relationship_ended_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($passport_copy_field_id)) $passport_copy =  WpBpXprofileData::where("field_id", $passport_copy_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($proof_of_address_field_id)) $proof_of_address =  WpBpXprofileData::where("field_id", $proof_of_address_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($bank_reference_field_id)) $bank_reference =  WpBpXprofileData::where("field_id", $bank_reference_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($professional_reference_field_id)) $professional_reference =  WpBpXprofileData::where("field_id", $professional_reference_field_id)->where("user_id", $wpuser_id)->first();
        if(isset($notes_field_id)) $notes =  WpBpXprofileData::where("field_id", $notes_field_id)->where("user_id", $wpuser_id)->first();

        $person = Person::where('person_code', $request->user_person_code)->first();

        if(empty($person)) {
          $person = new Person;
        }

        $person->person_code = $request->user_person_code;
        $person->person_type = (isset($person_type)) ?  $person_type->value : "";
        $person->person_role = "owner";
        $person->title = (isset($title)) ? $title->value : "";
        $person->first_name = (isset($first_name)) ? $first_name->value : "";
        $person->surname = (isset($surname)) ? $surname->value : "";        
        $person->nationality = (isset($nationality)) ? $nationality->value : "";        
        $person->passport_no = (isset($passport_no)) ? $passport_no->value : "";        
        $person->passport_expiry = (isset($passport_expiry)) ? $passport_expiry->value : "";        
        $person->tax_residence = (isset($tax_residence)) ? $tax_residence->value : "";        
        $person->tax_number = (isset($tax_number)) ? $tax_number->value : "";        
        $person->email = (isset($wpuser)) ? $wpuser->user_email : "";        
        $person->mobile_telephone = (isset($mobile_telephone)) ? $mobile_telephone->value : "";
        $person->work_telephone = (isset($work_telephone)) ? $work_telephone->value : "";
        $person->home_telephone = (isset($home_telephone)) ? $home_telephone->value : "";
        $person->home_address = (isset($home_address)) ? $home_address->value : "";
        $person->home_address_2 = (isset($home_address_2)) ? $home_address_2->value : "";
        $person->home_address_3 = (isset($home_address_3)) ?  $home_address_3->value : "";
        $person->home_address_6 = (isset($home_address_6)) ? $home_address_6->value : "";
        $person->home_address_5 = (isset($home_address_5)) ? $home_address_5->value : ""; 
        $person->postal_address = (isset($postal_address)) ? $postal_address->value : ""; 
        $person->postal_address_2 = (isset($postal_address_2)) ? $postal_address_2->value : ""; 
        $person->postal_address_3 = (isset($postal_address_3)) ? $postal_address_3->value : ""; 
        $person->postal_address_6 = (isset($postal_address_6)) ? $postal_address_6->value : ""; 
        $person->postal_address_5 = (isset($postal_address_5)) ? $postal_address_5->value : ""; 
        $person->preferred_currency = (isset($preferred_currency)) ? $preferred_currency->value : ""; 
        $person->account_registered = (isset($wpuser)) ? $wpuser->user_registered : ""; 
        $person->login_ip = (isset($wpuserloginlog)) ? $wpuserloginlog->ip : "";
        $person->relationship_commenced = (isset($relationship_commenced)) ? $relationship_commenced->value : ""; 
        $person->relationship_ended = (isset($relationship_ended)) ? $relationship_ended->value : ""; 
        $person->passport_copy = (isset($passport_copy)) ? $passport_copy->value : ""; 
        $person->proof_of_address = (isset($proof_of_address)) ? $proof_of_address->value : ""; 
        $person->bank_reference = (isset($bank_reference)) ? $bank_reference->value : ""; 
        $person->professional_reference = (isset($professional_reference)) ? $professional_reference->value : ""; 
        $person->notes = (isset($notes)) ? $notes->value : "";
        $saved = $person->save();

        $person_id = $person->id;
        if($person_id) {
            $company_wpuser = CompanyWpuser::find($request->companywpuser_id);
            $company_wpuser->owner_person_code = $request->user_person_code;
            $company_wpuser->save();
        }

        if($saved)
          return response()->json(['message' => 'Success'], 200);
        else
          return response()->json(['message' => 'Error saving data'], 400);

    }

    public function addtopersondb(Request $request) {
        $prefix = $request->prefix;

        $person_code = $request->input($prefix."_person_code");
        $person_role = $request->input($prefix."_person_role");

        $person = Person::where('person_code', $person_code)->first();

        if(empty($person)) {
          $person = new Person;
        }

        $companywpuser_shareholder_id = $request->input($prefix."_companywpuser_shareholder_id");
        $companywpuser_director_id = $request->input($prefix."_companywpuser_director_id");
        $companywpuser_secretary_id = $request->input($prefix."_companywpuser_secretary_id");

        $person->person_code = $person_code;
        $person->person_role = $person_role;
        $person->person_type = $request->input($prefix."_type");
        $person->first_name = $request->input($prefix."_name");
        $person->home_address = $request->input($prefix."_address");
        $person->home_address_3 = $request->input($prefix."_address_2") . " " . $request->input($prefix."_address_3");        
        $person->home_address_6 = $request->input($prefix."_address_4");
        $person->mobile_telephone = $request->input($prefix."_telephone");        
        $person->save();

        $person_id = $person->id;

        if($person_role=="shareholder" && $person_id) {
            $companywpuser_shareholder = CompanyWpuserShareholder::find($companywpuser_shareholder_id);  
            $companywpuser_shareholder->person_id = $person_id;
            $companywpuser_shareholder->person_code = $person_code;
            $saved = $companywpuser_shareholder->save();
        }        

        if($person_role=="director" && $person_id) {
            $companywpuser_director = CompanyWpuserDirector::find($companywpuser_director_id);  
            $companywpuser_director->person_id = $person_id;
            $companywpuser_director->person_code = $person_code;
            $saved = $companywpuser_director->save();
        }      

        if($person_role=="secretary" && $person_id) {
            $companywpuser_secretary = CompanyWpuserSecretary::find($companywpuser_secretary_id);
            $companywpuser_secretary->person_id = $person_id;
            $companywpuser_secretary->person_code = $person_code;
            $saved = $companywpuser_secretary->save();
        }        

        if($saved)
          return response()->json(['message' => 'Success'], 200);
        else
          return response()->json(['message' => 'Error saving data'], 400);

    }

    public function getperson(Request $request) {
        $person = Person::select('person_code')->get();

        return $person;
    }

    public function log_transaction_status(Request $request) {
              
        $transaction_log = new TransactionLog;
        $transaction_log->Merchant_User_Id = $request->Merchant_User_Id;
        $transaction_log->Merchant_ref_number = $request->Merchant_ref_number;
        $transaction_log->Lpsid = $request->Lpsid;
        $transaction_log->Lpspwd = $request->Lpspwd;
        $transaction_log->Transactionid = $request->Transactionid;
        $transaction_log->Requestid = $request->Requestid;
        $transaction_log->bill_firstname = $request->bill_firstname;
        $transaction_log->bill_lastname = $request->bill_lastname;
        $transaction_log->Purchase_summary = $request->Purchase_summary;
        $transaction_log->currencydesc = $request->currencydesc;
        $transaction_log->amount = $request->amount;
        $transaction_log->CardBin = $request->CardBin;
        $transaction_log->CardLast4 = $request->CardLast4;
        $transaction_log->CardType = $request->CardType;
        $transaction_log->merchant_ipaddress = $request->merchant_ipaddress;
        $transaction_log->CVN_Result = $request->CVN_Result;
        $transaction_log->AVS_Result = $request->AVS_Result;
        $transaction_log->Status = $request->Status;
        $transaction_log->CardToken = $request->CardToken;
        $saved = $transaction_log->save();

        return response()->json(['message' => 'Success'], 200);

    }

    public function exportPersonList()
    {
        // work on the export
        $persons = Person::select([
          "id", 
          "person_code as PersonCode", 
          "person_type as PersonType", 
          "third_party_company_name As CompanyName", 
          "third_party_company_jurisdiction As Jurisdiction",
          "third_party_company_reg_no As RegNo",
          "title As Title",
          "first_name As FirstName",
          "surname As Surname",
          "nationality As Nationality",
          "passport_no As PassportNo",
          "passport_expiry As PassportExpiry",
          "tax_residence As TaxResidence",
          "tax_number As TaxNumber",
          "email As Email",
          "mobile_telephone As MobileTelephone",
          "work_telephone As WorkTelephone",
          "home_telephone As HomeTelephone",
          "home_address As HomeAddress(Street)",
          "home_address_2 As HomeAddress(City)",
          "home_address_3 As HomeAddress(State)",
          "home_address_6 As HomeAddress(PostCode)",          
          "home_address_5 As HomeAddress(Country)",
          "postal_address As PostalAddress(Street)",
          "postal_address_2 As PostalAddress(City)",
          "postal_address_3 As PostalAddress(State)",
          "postal_address_6 As PostalAddress(PostCode)",          
          "postal_address_5 As PostalAddress(Country)",
          "preferred_currency As PreferredCurrency",
          "account_registered As AccountRegistered",
          "login_ip As LoginIP",
          "relationship_commenced As RelationshipCommenced",
          "relationship_ended As RelationshipEnded",
          "passport_copy As PassportCopy",
          "proof_of_address As ProofOfAddress",
          "bank_reference As BankReference",
          "professional_reference As ProfessionalReference",
          "notes As Notes",
          "created_at As CreatedAt",
          "updated_at As UpdatedAt"
          ])->get();

        Excel::create('test', function($excel) use($persons) {
          $excel->sheet('Sheet 1', function($sheet) use($persons) {
              $sheet->fromArray($persons);
          });
        })->export('xls');

    }

}
