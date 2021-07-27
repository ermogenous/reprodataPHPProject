<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 23/7/2021
 * Time: 11:46 π.μ.
 */

include("../../include/main.php");
include("../lib/odbccon.php");

$db = new Main();
$sybase = new ODBCCON();


$sql = "
select
inpol_policy_folder,
inpol_policy_serial,
inpol_policy_number,
inag_agent_code
from
inpolicies
JOIN inagents ON inag_agent_serial = inpol_agent_serial
WHERE
inpol_created_on BETWEEN '2021-01-01 00:00:00' AND '2021-12-31 23:59:59'
AND inpol_status NOT IN ('D','Q')
AND inpol_process_status = 'N'
";

$result = $sybase->query($sql);
echo "Total Policies:".$sybase->num_rows($result)."<hr>";
while ($row = $sybase->fetch_assoc($result)){
    if (checkIfFolderExists($row['inag_agent_code'],$row['inpol_policy_number'],'policy')){

    }
    else {
        $folder ='\\\\hq-terminal\\Documents\\'.$row['inag_agent_code']."\\".$row['inpol_policy_number'];
        echo "Policy ".$row['inpol_policy_number']." (".$row['inpol_policy_serial'].") Folder does not exists<br>";
        echo $folder." -> ";
        if (is_dir($folder)){
            echo "Exists";
        }
        else {
            echo "No";
        }
        echo "<hr>";
    }
}

/**
 * @param $agent
 * @param $policy
 * @param string $check [agent][policy]
 */
function checkIfFolderExists($agent,$policy,$check='agent'){
    if ($check == 'agent'){
        $folder = '\\\\hq-terminal\\Documents\\'.$agent;
        if (is_dir($folder)){
            return true;
        }
        else {
            return false;
        }
    }
    if ($check == 'policy'){
        $folder = '\\\\hq-terminal\\Documents\\'.$agent."\\".$policy;
        if ($policy == ''){
            return false;
        }
        if (is_dir($folder)){
            return true;
        }
        else {
            return false;
        }
    }
}

function createPolicyFolder($policySerial){
    global $sybase;
}
