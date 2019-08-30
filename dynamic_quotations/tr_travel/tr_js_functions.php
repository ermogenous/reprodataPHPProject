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

    var membersSelectionList = ["5_oqqit_rate_5","5_oqqit_rate_10"];

    function showHideMembers(id) {
        selectionField = membersSelectionList[((id*1) -1)];
        //first check if the previous member is open
        let previous = (id * 1) - 1;



        if ($('#' + selectionField).val() == '1') {
            $('#member_' + id + '_contents').hide();
            $('#member_' + id + '_plus').show();
            $('#member_' + id + '_minus').hide();
            $('#' + selectionField).val('0');
        }
        else {
            $('#member_' + id + '_contents').show();
            $('#member_' + id + '_plus').hide();
            $('#member_' + id + '_minus').show();
            $('#' + selectionField).val('1');
        }

    }

    function checkAllMembersShowHide() {


        $.each(membersSelectionList ,function (index,value){
            index++;
            //make opposite
            if ($('#' + value).val() == '1'){
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
    });
</script>