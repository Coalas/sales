<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
        <title></title>
 <script type="text/javascript" charset="utf-8">
$(document).ready(function() {
$.getJSON("json_select.php", showRequestTypes);
function showRequestTypes(data, textStatus) {

        $.each(data,
            function() {

                var option = new Option(this.name, this.idexpcategories);
                // Use Jquery to get select list element
                var dropdownList = $("#category")[0];

                if ($.browser.msie) {
                    dropdownList.add(option);
                }

                else {

                    dropdownList.add(option, null);

                }
            }
            );}

});

 </script>
    </head>
    <body>
    <select name="category" id="category">
    <option value="">-- Select Value --</option>
    
</select> 
    <?php
    require_once('config.php');
    //require_once('encode.php');
    $models = Doctrine_Core::loadModels('models');
    




    ?>
    </body>
</html>
