<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>"Sprzedaż" - Mailing</title>
	<meta http-equiv="Content-Language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="David Herreman (www.free-css-templates.com)" />
	<meta name="description" content="Free Css Template" />
	<meta name="keywords" content="free,css,template" />	
	<meta name="Robots" content="index,follow" />
	<meta name="Generator" content="sNews 1.5" />
	<link rel="stylesheet" type="text/css" href="../media/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../media/css/demo_table.css" media="screen" />
        <link type="text/css" href="../media/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<script type="text/javascript" language="javascript" src="../media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../media/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../media/js/jquery.validate.js"></script>
<script type="text/javascript" charset="utf-8">
var oTable;
var gaiSelected =  [];
var aPos;

$(document).ready(function() {


	/* Init the table */
	oTable = $("#example").dataTable({
		"bProcessing": true,
                "bAutoWidth": false,
                "bStateSave": true,
		"bServerSide": true,
		"sAjaxSource": "json.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( jQuery.inArray(aData[0], gaiSelected) != -1 )
			{
				$(nRow).addClass('row_selected');
			}
			return nRow;
		},
		"aoColumnDefs": [
			{  "bVisible": 0,
                           "aTargets": [0]
                        }

		],
                "sPaginationType": "full_numbers",
                "fnDrawCallback": function()    {
                    var $loading = $('loading...');

                 $('.deleteRow').each(function() {

                            $(this).click(function() {
				var nTr = $(this).closest("tr").get(0);
                                aPos = oTable.fnGetPosition( nTr ); // gets the position
                                var data = {'id' : $(this).attr('id') };

                                 // example of calling the confirm function
		// you must use a callback function to perform the "yes" action
		confirm("Continue to the SimpleModal Project page?", function () {
		$.get(
                                   'delete.php',
                                   data,
                                   function (responseText, textStatus, XMLHttpRequest) {
                                      //console.log('responseText: '+responseText);
                                      if (responseText == 'ok')
                                      oTable.fnDeleteRow(aPos);
                                   }
                                );
		});


				return false;
			});


                });
                },
                "oLanguage": {
			"sUrl": "../media/language/pl_PL.txt"
		}


	});// datatables
	function confirm(message, callback) {
	$("#dialog-confirm").dialog({
                       // autoOpen: false,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				'Usuń': function() {
                                        if ($.isFunction(callback)) {
					callback.apply();
				}
					$(this).dialog('close');
				},
				"Anuluj": function() {

					$(this).dialog('close');
				}
			}
		});
}
	/* Click event handler */
	$('#example tbody tr').live('click', function () {
		var aData = oTable.fnGetData( this );
		var iId = aData[0];

		if ( jQuery.inArray(iId, gaiSelected) == -1 )
		{
			gaiSelected[gaiSelected.length++] = iId;
		}
		else
		{
			gaiSelected = jQuery.grep(gaiSelected, function(value) {
				return value != iId;
			} );
		}

		$(this).toggleClass('row_selected');
	} );

   $('#newClient').click(function(){
   mode = 'add';
   dialog.dialog('open');

   });

} ); //ready

</script>
</head>

<body>
		

		<?php
                include('../media/menu.html');
                ?>
	

	
<div class="content">
	<div id="main">
		<div class="padding">
                    <h1>Mailing</h1>
                    <h3>Wiadomości email</h3>
<p>
<div id="dynamic">
    
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="40%">ID</th>
			<th width="30%">Temat Wiadomości Email</th>
			<th width="10%">Data</th>
			<th width="10%">Akcja</th>


		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>ID</th>
			<th></th>
			<th></th>
			<th></th>


		</tr>
	</tfoot>
</table>
<input type="button" name="newEmail" class="groovybutton" value="Nowy" onClick="location.href='edit.php'"></input>
</div>
</p>
                   
                </div>
			</div>
		</div>
	<div class="clear"></div>
	
	<div id="footer">

	<br />
	&copy; Copyright 2010
	</div>	
	
<div id="dialog-confirm" title="Czy na pewno usunąć rekord?">

</div>

</body>
</html>
