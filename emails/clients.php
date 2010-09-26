<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />
		
		<title>Sprzedaż - Klienci</title>
		<style type="text/css" title="currentStyle">
			@import "../media/css/style.css";
			@import "../media/css/demo_table.css";
		</style>
                <link type="text/css" href="../media/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
		<script type="text/javascript" language="javascript" src="../media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>
                <script type="text/javascript" language="javascript" src="../media/js/jquery-ui-1.8.4.custom.min.js"></script>
                <script type="text/javascript" language="javascript" src="../media/js/jquery.validate.js"></script>
		<script type="text/javascript" charset="utf-8">
var oTable;
var gaiSelected =  [];
var aPos;
var mode;

$(document).ready(function() {

 /*   $("#formSubmit").click(function(){
     var data = $("#form").serialize();
     $.ajax({
			type: "POST",
			url: "../send.php",
			data: data,
                        dataType: 'json',
			success: function(){
				//$('form#submit').hide(function(){$('div.success').fadeIn();});

			}
		});
});*/

      /*  $("#clientForm").submit(function(){
            //$("#clientForm")[0].reset();
            $('#dialog-form').dialog("close");
            
            return false;
        //alert($('#clientForm input[name="name"]').val());



        });*/
        
	$('#form').submit( function() {
		if(gaiSelected == ''){
		alert ("Zaznacz co najmniej jeden rekord ");
		return false;
	  }
	else {
          
           var data = gaiSelected.toString();
           var nHidden = document.createElement( 'input' );
		nHidden.type = 'hidden';
		nHidden.name = "data";
		//nHidden.value = $('input:eq(0)', nNodes).val();
		nHidden.value=data;
                this.appendChild(nHidden);

           // var dataString = JSON.stringify(gaiSelected);
   
    //return false;
	}

		
	} );

	/* Init the table */
	oTable = $("#example").dataTable({
		"bProcessing": true,
                "bAutoWidth": false,
                "bStateSave": true,
		"bServerSide": true,
		"sAjaxSource": "jsonC.php",
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
                        $('.modalForm').each(function() {
                           
                            $(this).click(function() {
                                mode ='edit';
				dialog.dialog('open');
                                // alert($('.modalForm').html());
                                var nTr = $(this).closest("tr").get(0);
                                aPos = oTable.fnGetPosition( nTr ); // gets the position
                                
                                var data = {'id' : $(this).attr('id') };
                                // var qid = $(this).attr('id');
                                 $.get(
                                   '../testa.php',
                                   data,
                                   function (responseText, textStatus, XMLHttpRequest) {
                                      //console.log(responseText);
                                     // console.log('responseText: '+responseText);
                                     // var tstring = responseText.split('~$~');
                                      //console.log('split response '+tstring);
                                      var obj = jQuery.parseJSON(responseText);
                                   
                                      $('#clientForm input[name="id"]').val(obj.idclients);
                                      $('#clientForm input[name="name"]').val(obj.name);
                                      $('#clientForm input[name="lastName"]').val(obj.lastName);
                                      $('#clientForm input[name="city"]').val(obj.Address[0].city);
                                      $('#clientForm input[name="street"]').val(obj.Address[0].street);
                                      $('#clientForm input[name="zipCode"]').val(obj.Address[0].zipCode);
                                      $('#clientForm input[name="tel"]').val(obj.tel);
                                      $('#clientForm input[name="email"]').val(obj.email);
                                      $('#clientForm input[name="www"]').val(obj.www);
                                      if (obj.target == 1)                                 // jesli true dodaj atrybut checked
                                      $('#clientForm input[name="target"]').attr("checked", obj.target);else
                                          $('#clientForm input[name="target"]').removeAttr("checked");

                                    // console.log(obj.target);
                                     //$('#edit').html(responseText);
                                     // $('#edit').dialog( "option", "width", 660 );
                                     // $('#edit').dialog( "option", "title", "Edit Question ID: "+qid );
                                     // $('#edit').dialog('open');
                                     //$('#loading').hide();
                                     //loadcke($("#sla").val());
                                   }
                                );

				return false;
			});

                     
                });
                 $('.deleteRow').each(function() {

                            $(this).click(function() {
				var nTr = $(this).closest("tr").get(0);
                                aPos = oTable.fnGetPosition( nTr ); // gets the position
                                var data = {'id' : $(this).attr('id') };
                                 
                                 // example of calling the confirm function
		// you must use a callback function to perform the "yes" action
		confirm("Continue to the SimpleModal Project page?", function () {
		$.get(
                                   '../delete.php',
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
               var aform = $("#clientForm").validate({
		rules: {
			name: "required",
			city: "required",
			zipCode: {
				required: true,
				minlength: 6,
                                maxlength: 6
			},
			street: {
				required: true,
				minlength: 4
			},
			tel: {
				required: false,
				minlength: 4

			},
			email: {
				required: false,
				email: true
			},
			www: {
				required: false,
				url: true
			}

		},
		messages: {
			name: "Wpisz nazwe",
			city: "Wpisz miejscowosc",
			zipCode: {
				required: "Wpisz kod pocztowy",
				minlength: "Podaj poprawny kod pocztowy",
                                maxlength: "Podaj poprawny kod pocztowy"
			},
			street: {
				required: "Wpisz ulicę",
				minlength: "Wpisz prawidłową nazwę ulicy"
			},
			tel: {
				minlength: "Wpisz numer telefonu"
			},
			email: "Wpisz poprawny adres email",
			www: "Wpisz poprawny adres URL"
		},
                submitHandler: function(form) {
                    data =$('#clientForm').serializeArray();
                    $.post('../save.php',data, function(resp){}, "json");
                   // console.log(data);
                     if (data.length>8)
                    data.splice(data.length-1,1);
                    data.splice(3,2);
                   // console.log(data);
                   
                    rows = [];
                    for (i=0;i<data.length;i++) {
                        rows.push(data[i].value);
                    }
                    str = '<a class="modalForm" href="../edit.php" id="'+data[0].value+'"><img border="0" src="../media/images/ico.edit.gif" /></a> <a href="" id="'+data[0].value+'" class="deleteRow"><img border="0" src="../media/images/delete.png"/></a>';
                    rows.push(str);
                    //console.log(rows);
                    //console.log(str);
                    if (mode == 'edit')
                    oTable.fnUpdate(rows,aPos,0,0);
                    oTable.fnDraw(false);



                }

	});
               dialog = $('#dialog-form').dialog({
					autoOpen: false,
                                        //bgiframe: true,
                                        modal: true,
					width: 800,
					buttons: {
						"Ok": function() {
							//$(this).dialog("close");

                                                        $("#clientForm").submit();


						},
						"Cancel": function() {
                                                         aform.resetForm();
                                                         $("#clientForm")[0].reset();
							$(this).dialog("close");
						}
					}
				});
   $('#newClient').click(function(){
   mode = 'add';
   dialog.dialog('open');
   
   });
   //code to hide topic selection, disable for demo
	var newsletter = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital = newsletter.is(":checked");
	var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
} ); //ready

var amodal = $("#my-modal-form").dialog({
	   bgiframe: true,
	   autoOpen: false,
	   height: 350,
	   width: 300,
	   modal: true,
	   buttons: {
	      'Update Data': function()
		  {
		  	// JDR: submit the form
		  	$("#modal-form-test").submit();
		  },
	      Cancel: function()
		  {
		  	// JDR: close the dialog, reset the form
		    $(this).dialog('close');// aform.resetForm();
		  }
	   }
	});
      

</script>
</head>
<body id="dt_example">
	<?php
          include('../media/menu.html');
         ?>
<div class="content">
<div id="main">
<div class="padding">
			
<h1>Mailing</h1>
<h3>Adresaci</h3>
<p></p>
			
			
<form id="form" action="../send.php" method="post" >
					
<div id="dynamic">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="40%">ID</th>
			<th width="30%">Nazwisko, Imię</th>
			<th width="10%">Adres</th>
			<th width="8%">Tel</th>
			<th width="10%">Email</th>
			<th width="2%">www</th>
                        
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
			<th></th>
			<th></th>
                       
		</tr>
	</tfoot>
</table>
			</div>
                
<div class="spacer"></div>

<div style="text-align:left; padding-bottom:1em;">
<?php
echo "<input type=\"hidden\" id=\"idemail\" name=\"idemail\" size=\"50px\" value=\"".$_GET['id']."\"/>";
?>
<button type="submit" class="groovybutton">Wyślij</button>

</div>
</form>
</div></div>
<!--                        <button id="formSubmit">Submit</button>-->

</div>
</body>
</html>