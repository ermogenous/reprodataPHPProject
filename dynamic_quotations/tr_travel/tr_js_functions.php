<script language="JavaScript" type="text/javascript">

    //this function is executed on submit.
    function custom_js_functions_return() {
        var result;
        result = '';


//FORM FIXES.

//update the contents field insured_amount_2 if contents section is oppened.
//document.getElementById('5_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_5').value;
//document.getElementById('6_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_6').value;

//return the result
        return result;
    }


    function js_function_on_load() {


    }

    var membersSelectionList =
        ["6_oqqit_rate_1",
            "6_oqqit_rate_6",
            "6_oqqit_rate_11",
            "7_oqqit_rate_1",
            "7_oqqit_rate_6",
            "7_oqqit_rate_11",
            "8_oqqit_rate_1",
            "8_oqqit_rate_6",
            "8_oqqit_rate_11"];

    function showHideMembers(id, action = 'auto') {
        selectionField = membersSelectionList[((id * 1) - 1)];

        if ($('#' + selectionField).val() == '1') {
            if (action == 'auto') {
                $('#member_' + id + '_contents').hide();
                $('#member_' + id + '_plus').show();
                $('#member_' + id + '_minus').hide();
                $('#' + selectionField).val('0');
            }
            else {
                if (confirm('<?php show_quotation_text('Το μέλος αυτό θα αφαιρεθεί απο την κάλυψη. Είσαι σίγουρος?','This will remove this member from the cover. Are you sure?');?>') || action == 'auto') {
                    $('#member_' + id + '_contents').hide();
                    $('#member_' + id + '_plus').show();
                    $('#member_' + id + '_minus').hide();
                    $('#' + selectionField).val('0');
                }
            }

        }
        else {
            var previous = 0;
            if (id >= 2) {
                previous = id - 2;
            }

            //console.log("Previous ID:"+previous + ' ID=' + id + ' Previous Selection:' + membersSelectionList[previous] + "->" +  $('#' + membersSelectionList[previous]).val() );

            //check if the previous is open
            if ($('#' + membersSelectionList[previous]).val() == '1' || previous == 0) {
                $('#member_' + id + '_contents').show();
                $('#member_' + id + '_plus').hide();
                $('#member_' + id + '_minus').show();
                $('#' + selectionField).val('1');
            }


        }

    }

    function checkAllMembersShowHide() {


        $.each(membersSelectionList, function (index, value) {
            index++;
            //make opposite
            if ($('#' + value).val() == '1') {
                $('#' + value).val('0');
            }
            else {
                $('#' + value).val('1');
            }
            showHideMembers(index);
        });
    }


    $(document).ready(function () {
        checkAllMembersShowHide();
        packageSelection();
        geographicalAreaOnChange();
        winterSportsOnChange();
        destinationOnChange();
    });
</script>