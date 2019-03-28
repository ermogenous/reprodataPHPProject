<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/3/2019
 * Time: 3:28 ΜΜ
 */

$data = "
Albania#
Algeria#
Andorra#
Angola#
Antigua & Barbuda#
Argentina#
Armenia#
Aruba#
Australia#
Azerbaijan#
Bahamas#
Bahrain#
Bangladesh#
Barbados#
Belarus#
Belgium#
Belize#
Benin#
Bermuda#
Bhutan#
Bolivia#
Bosnia & Herzegovina#
Botswana#
Brazil#
Bulgaria#
Burkina Faso#
Burundi#
Cambodia#
Cameroon#
Canada#
Cape Verde#
Cayman Islands#
Central African Republic#
Chad#
Chile#
China#
Colombia#
Comoros#
Costa Rica#
Croatia#
Curacao#
Cyprus#
Czech Republic#
Denmark#
Djibouti#
Dominica#
Dominican Republic#
East Timor#
Ecuador#
Egypt#
El Salvador#
Equatorial Guinea#
Eritrea#
Estonia#
Ethiopia#
Fiji#
Finland#
France#
Gabon#
Gambia#
Georgia#
Germany#
Ghana#
Grenada#
Guam#
Guinea#
Guinea-Bissau#
Guyana#
Haiti#
Honduras#
Hong Kong#
Hungary#
Iceland#
India#
Indonesia#
Ireland#
Israel & the Palestinian Authority#
Italy#
Jamaica#
Japan#
Jordan#
Kazakhstan#
Kenya#
Kiribati#
Kuwait#
Kyrgyzstan#
Laos#
Latvia#
Lebanon#
Lesotho#
Liechtenstein#
Lithuania#
Luxembourg#
Macau#
Macedonia#
Madagascar#
Malawi#
Malaysia#
Maldives#
Mali#
Malta#
Marshall Islands#
Mauritania#
Mauritius#
Micronesia#
Monaco#
Mongolia#
Morocco#
Mozambique#
Namibia#
Nauru#
Nepal#
Netherlands#
New Zealand#
Nicaragua#
Niger#
Norway#
Oman#
Pakistan#
Palau#
Panama#
Papua New Guinea#
Paraguay#
Peru#
Philippines#
Poland#
Portugal#
Puerto Rico#
Qatar#
Romania#
Russia#
Rwanda#
Saint Kitts & Nevis#
Saint Lucia#
Samoa#
Sao Tome & Principe#
Saudi Arabia#
Senegal#
Serbia & Montenegro#
Seychelles#
Sierra Leone#
Singapore#
Slovakia#
Slovenia#
Solomon Islands#
Somalia#
South Africa#
Spain#
Sri Lanka#
Suriname#
Swaziland#
Sweden#
Switzerland#
Taiwan#
Tajikistan#
Tanzania#
Thailand#
The Channel Islands#
The Netherlands Antilles#
Togo#
Tonga#
Trinidad & Tobago#
Tunisia#
Turkey#
Turkmenistan#
Tuvalu#
UAE#
Uganda#
UK#
Ukraine#
Uruguay#
Uzbekistan#
Vanuatu#
Venezuela#
Vietnam#
Virgin Island#
Zambia";

$lines = explode('#',$data);
foreach($lines as $line){

    if (substr($line,0,2) == '
'){
        $line = substr($line,2);
    }


    echo "INSERT INTO codes SET cde_type = 'Countries', 
          cde_value = '".$line."', 
          cde_value_label = 'Country Name', 
          cde_value_2 = '', 
          cde_value_label_2 = 'Short Code',
          cde_option_value = 'Open',
          cde_option_label = 'Open/Reffered (Permission)';<br>\n\n";
}