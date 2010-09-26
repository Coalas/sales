<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <link type="text/css" href="media/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="media/js/jquery-ui-1.8.4.custom.min.js"></script>

        <title></title>
 <script type="text/javascript" charset="utf-8">
$(document).ready(function() {
$.getJSON("json_select.php", showRequestTypes);
function showRequestTypes(data, textStatus) {
        $("#reportTable tbody").html("");
        $.each(data,  function(i, row) {
               
                //var option = new Option(this.name, this.idexpcategories);
                // Use Jquery to get select list element
           var tblRow =	"<tr>"
			+"<td>"+row[0]+"</td>"
			+"<td>"+row[1]+"</td>"
			+"</tr>"
			$(tblRow).appendTo("#reportTable tbody");

            }
            );}

});

 </script>
    </head>
    <body>
     <table id="reportTable" class="ui-widget ui-widget-content">
      <thead>
      <tr class="ui-widget-header ">
        <th class="">Rodzaj Wydatku</th>
        <th class="lastname">Kwota Wydatku</th>
      </tr>
      </thead>
      <tbody>
     
      </tbody>
    </table>
    <?php
    require_once('config.php');
    //require_once('encode.php');
    $models = Doctrine_Core::loadModels('models');
   
    ?>
    </body>
</html>
