<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/12/2019
 * Time: 11:48 π.μ.
 */

function ainsuranceCertificate($policyObject)
{
    global $db;


    $html = '
<style>
.certificateHeader{
color: #000099;
font-size: 20px;
}
.certificateMainBlueText{
color: #000099;
font-size: 10px;
font-weight: bold;
}
.certificateMainBlackText{
color: black;
font-size: 10px;
font-weight: bold;
}
tr.border_bottom td {
  border-bottom:1px solid #000099;
  padding-top: 3px;
  padding-bottom: 3px;
}

.elementPageBreak{
    page-break-before: always;
}
</style>
';

    //get all members
    $sql = 'SELECT * FROM ina_policy_items WHERE inapit_policy_ID = ' . $policyObject->policyData['inapol_policy_ID'];
    $result = $db->query($sql);
    $totalMembers = $db->num_rows($result);
    echo $totalMembers;
    $currentMemberNum = 0;
    while ($member = $db->fetch_assoc($result)) {
        $currentMemberNum++;
        $html .= '
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td class="certificateMainBlueText" colspan="2">
                <img src="' . $db->admin_layout_url . 'images/demetriou-insurance.jpg">
                <br><br>
                <strong class="certificateHeader">Certificate of Insurance</strong>
                <br>
                This Certificate is evidence of cover and must be read in conjunction with the Policy Wording.
                <br><br><br><br>
            </td>
        </tr>
        <tr class="border_bottom">
            <td align="left" width="50%" class="certificateMainBlueText ">
                Product Name:
            </td>
            <td align="right" class="certificateMainBlackText">
                DCare International Medical Insurance
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                UMR Contract Number:
            </td>
            <td align="right" class="certificateMainBlackText">
                B0429BA1905243
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                Insurer of this product:
            </td>
            <td align="right" class="certificateMainBlackText">
                Lloyd`s Insurance Company S.A.
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                Certificate of Insurance Number:
            </td>
            <td align="right" class="certificateMainBlackText">
                ' . $policyObject->getCertificateNumber() . '
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                Underwriting Method:
            </td>
            <td align="right" class="certificateMainBlackText">
                FMU
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                Applicable Law and Jurisdiction:
            </td>
            <td align="right" class="certificateMainBlackText">
                Cyprus
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText ">
                Original Policy Start Date:
            </td>
            <td align="right" class="certificateMainBlackText">
                ' . $db->convertDateToEU($policyObject->policyData['inapol_period_starting_date']) . '
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText">
                Policy Holder:
            </td>
            <td align="right" class="certificateMainBlackText">
                ' . $policyObject->policyData['cst_name'] . ' ' . $policyObject->policyData['cst_surname'] . '
            </td>
        </tr>
        
        <tr>
            <td align="left" class="certificateMainBlueText " colspan="2">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr class="border_bottom">
                        <td width="20%" class="certificateMainBlueText">Residential Address</td>
                        <td width="30%" class="certificateMainBlackText">
                            ' . $policyObject->policyData['cst_city_code_ID'] . ', ' . $policyObject->policyData['cst_address_line_1']
                . ' ' . $policyObject->policyData['cst_address_line_2'] . '
                        </td>
                        <td width="20%" class="certificateMainBlueText">Home Address</td>
                        <td width="30%" class="certificateMainBlackText" align="right">
                            No field in customers
                        </td>
                    </tr>
                    <tr class="border_bottom">
                        <td class="certificateMainBlueText">Postcode</td>
                        <td class="certificateMainBlackText">
                            No field in customers
                        </td>
                        <td class="certificateMainBlueText">Postcode</td>
                        <td class="certificateMainBlackText" align="right">
                            No field in customers
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText">
                Country of Residence:
            </td>
            <td align="right" class="certificateMainBlackText">
                No field in customers
            </td>
        </tr>
        
        <tr>
            <td align="left" class="certificateMainBlueText " colspan="2">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr class="border_bottom">
                        <td width="20%" class="certificateMainBlueText">
                            Period of Insurance: 
                            <br> 
                            <span style="font-style: italic; font-weight: normal;">Both dates inclusive</span></td>
                        <td width="30%" class="certificateMainBlackText">
                            <span class="certificateMainBlueText">From:</span>
                            &nbsp;&nbsp;' . $db->convertDateToEU($policyObject->policyData['inapol_starting_date']) . '
                        </td>
                        <td width="20%" class="certificateMainBlueText">To:</td>
                        <td width="30%" class="certificateMainBlackText" align="right">
                            ' . $db->convertDateToEU($policyObject->policyData['inapol_expiry_date']) . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr class="border_bottom">
            <td align="left" class="certificateMainBlueText">
                Area of Cover:
            </td>
            <td align="right" class="certificateMainBlackText">
                
            </td>
        </tr>
        
    </table>
    
    
        ';
        if ($currentMemberNum < $totalMembers) {
            $html .= '<div class="elementPageBreak">';
        }
    }

    return $html;
}