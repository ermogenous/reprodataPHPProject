<!DOCTYPE html>
<html>
<head>
<title>jQueryUI Colour Picker</title>

<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script
    src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<link
    href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css"
    rel="stylesheet" type="text/css" />

<script src="colorpicker/jquery.colorpicker.js"></script>
<link href="colorpicker/jquery.colorpicker.css" rel="stylesheet"
    type="text/css" />


<style>
body {
    font-family: Arial;
    width: 550px;
}

.frm-colorpicker {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.input-row {
    margin-bottom: 20px;
}

.input-field {
    width: 250px;
    padding: 10px;
    border: #e0dfdf 1px solid;
    text-transform: uppercase;
    text-align: left;
    vertical-align: bottom;
}

.ui-button .ui-button-text img {
    width: 20px;
}

.ui-button {
    border-radius: unset;
    background: #FFF;
    margin-left: 10px;
}

.ui-button-text-only .ui-button-text {
    padding: .2em .4em;
}
</style>
</head>

<body>
    <h2>jQueryUI color picker without bootstrap</h2>

    <div class="frm-colorpicker">
        <form>

            <div class="input-row">

                Hex Value : <input id="colorpicker-full"
                    class="input-field" type="text" />

            </div>

        </form>
    </div>



    <script>
       
$(function() {
    $('#colorpicker-full').colorpicker({
        showOn:         'both',
        showNoneButton: true,
        showCloseButton: true,
        showCancelButton: true,
        colorFormat: ['#HEX'],
        position: {
		   my: 'center',
		   at: 'center',
		   of: window
		  },
	   modal: true
    });
}); 
</script>
</body>
</html>
