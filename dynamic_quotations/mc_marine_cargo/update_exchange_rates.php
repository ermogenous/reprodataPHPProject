<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 2/9/2021
 * Time: 4:54 μ.μ.
 */


function updateExchangeRates()
{
    global $db;
//check if there was already an update today
    $today = date('Y-m-d');
    $lastUpdate = $db->get_setting('kemter_currency_rate_last_update', 'value_date');


    if ($db->compare2dates($today, explode(" ", $lastUpdate)[0], 'yyyy-mm-dd') == 1) {
        // set API Endpoint and API key
        $endpoint = 'latest';
        $access_key = '89922c2dcd8f749ecc7bf39c0d13e888';

        // Initialize CURL:
        $ch = curl_init('http://api.exchangeratesapi.io/v1/' . $endpoint . '?access_key=' . $access_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        foreach ($exchangeRates['rates'] as $name => $value) {

            $newValues['fld_value_3'] = $value;
            $db->db_tool_update_row('codes', $newValues, 'cde_value = "' . $name . '" AND cde_type= "Currency"', 0, 'fld_', 'execute', 'cde_');

        }
        $db->update_setting('kemter_currency_rate_last_update', '', 0, date('Y-m-d'));
        $db->update_log_file_custom(print_r($exchangeRates,true),'Update exchange rates successfully');
        return true;
    } else {
        return false;
    }

}
