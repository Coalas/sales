<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />
		
		<title>DataTables example</title>
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
 $.getJSON("json_select.php", showRequestTypes);

 generateYearReport($('#year').val());

$('#loadingDiv')
    .hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    })
;
$('#year').change(function(){
  $('span.reportYear').html($(this).val());
  oTable.fnFilter( $(this).val(), 0 );
  generateYearReport($(this).val());
});

function generateYearReport(year){

$.get('json_report.php', 'year='+year, showRequestTypes2 , 'json')
    
}
function showRequestTypes2(data, textStatus) {
        $("#reportTable tbody").html("");
        if (data.length == 0)
        $("#reportTable tbody").html("Brak Wydatków");
        else
        $.each(data, function(i, row){
        if (row[0] == 'Suma')
            tblRow = "<tr class=\"ui-widget-header\">"+"<td>"+row[0]+"</td>"+"<td>"+row[1]+"</td>"+"</tr>"; else
        tblRow = "<tr>"+"<td>"+row[0]+"</td>"+"<td>"+row[1]+"</td>"+"</tr>";
        $(tblRow).appendTo("#reportTable tbody");

        });

}

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
                        $('.modalForm').each(function() {
                           
                            $(this).click(function() {
                                mode ='edit';
				
                                // alert($('.modalForm').html());
                                var nTr = $(this).closest("tr").get(0);
                                aPos = oTable.fnGetPosition( nTr ); // gets the position
                                
                                var data = {'id' : $(this).attr('id') };
                               
                                 $.get(
                                   'testa.php',
                                   data,
                                   function (responseText, textStatus, XMLHttpRequest) {
                                      //console.log(responseText);
                                     // console.log('responseText: '+responseText);
                                     // var tstring = responseText.split('~$~');
                                      //console.log('split response '+tstring);
                                      var obj = jQuery.parseJSON(responseText);
                                   
                                      $('#clientForm input[name="id"]').val(obj.idexpenses);
                                      $('#clientForm input[name="amount"]').val(obj.amount);
                                      $('#clientForm select[name="category"]').val(obj.expcategory_id);
                                     
//                                      if (obj.target == 1)                                 // jesli true dodaj atrybut checked
//                                      $('#clientForm input[name="target"]').attr("checked", obj.target);else
//                                          $('#clientForm input[name="target"]').removeAttr("checked");
//                                      if (obj.Address[1]!== undefined && obj.Address[1] !== null)     {
//                                          $('#clientForm input[name="city2"]').val(obj.Address[1].city);
//                                          $('#clientForm input[name="zipCode2"]').val(obj.Address[1].zipCode);
//                                          $('#clientForm input[name="street2"]').val(obj.Address[1].street);
//                                          $('#clientForm input[name="secondaddr"]').attr("checked", "true");
//                                          $("#secondaddr_topics").find("input").attr("disabled", false);
//                                      } else
//                                          {
//                                          $('#clientForm input[name="secondadrr"]').removeAttr('checked');
//                                          $("#secondaddr_topics").find("input").attr("disabled", true);
//                                          }
                                     // console.log(obj.target);
                                     //$('#edit').html(responseText);
                                     // $('#edit').dialog( "option", "width", 660 );
                                     // $('#edit').dialog( "option", "title", "Edit Question ID: "+qid );
                                     // $('#edit').dialog('open');
                                     //$('#loading').hide();
                                     //loadcke($("#sla").val());
                                    
                                     dialog.dialog('open');
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
                                   'delete.php',
                                   data,
                                   function (responseText, textStatus, XMLHttpRequest) {
                                      //console.log('responseText: '+responseText);
                                      if (responseText == 'ok'){
                                      oTable.fnDeleteRow(aPos);
                                      generateYearReport($('#year').val());
                                   }}
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
			category: "required",
			amount: {
				required: true,
                                number: true
                                
			}

		},
		messages: {
			category: "Wpisz nazwe",
                        amount: {
				required: "Wpisz kod pocztowy",
                                number: "Kwota musi być liczbą, grosze piszemy po kropce"
				
			}
		},
                submitHandler: function(form) {
                    data =$('#clientForm').serializeArray();
                    $.post('save.php',data, function(resp){
                    
                    oTable.fnDraw(true);

                    $('#dialog-form').dialog('close');
                    $("#clientForm")[0].reset();
                    generateYearReport($('#year').val());

                    });

                    //if (data.length>8)
                    //data.splice(data.length-4,4);
                    //data.splice(3,2);

//                    formatka = [];
//                    for (i=0;i<data.length;i++) {
//                     if (i == 2)
//                         formatka.push(data[2].value+data[3].value+data[4].value);else
//                     formatka.push(data[i].value);
//                    }
                    //console.log('wiersz '+formatka);
                    
                    //console.log('parametry po mdyfikacji '+data);
                   
//                    rows = [];
//                    for (i=0;i<data.length;i++) {
//                        rows.push(data[i].value);
//                    }
//                    str = '<a class="modalForm" href="../edit.php" id="'+data[0].value+'"><img border="0" src="../media/images/ico.edit.gif" /></a> <a href="" id="'+data[0].value+'" class="deleteRow"><img border="0" src="../media/images/delete.png"/></a>';
//                    rows.push(str);
                    //console.log('wiersz '+rows);
                    //console.log(str);
                    //if (mode == 'edit')
                    //oTable.fnUpdate(rows,aPos,0,0);
                    
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
                                                         //aform.resetForm();
                                                         
							$(this).dialog("close");
                                                        $("#clientForm")[0].reset();
						}
					}
				});
  $('#newClient').click(function(){
  mode = 'add';
  $('#clientForm input[name="id"]').val("");
  $('#clientForm input[name="secondadrr"]').removeAttr('checked');
  $("#secondaddr_topics").find("input").attr("disabled", true);
  //$("#secondaddr_topics").hide();
   dialog.dialog('open');
   
   });
   //code to hide topic selection, disable for demo
	var secondaddr = $("#secondaddr");
	// secondaddr topics are optional, hide at first
	var inital = secondaddr.is(":checked");
	var topics = $("#secondaddr_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when secondaddr is checked
	secondaddr.change(function() {
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


  </script>
	</head>
	<body id="dt_example">
	<?php
          include('../media/menu.html');
         ?>
<div class="content">
<div id="main">
<div class="padding">
<div id="loadingDiv" class="right"><img alt="loading" src="../media/images/loading.gif" /></div>
<h1>Wydatki</h1>
<h3>Lista wydatków</h3>
<p>
   ROK: <select name="year" id="year">
<!--        <option selected value="2010">2010</option>-->
<!--        <option value="2009">2009</option>-->
        <?php
        $currentYear = Date('Y');
        $loopYear = 2008;
        while ($loopYear !== intval($currentYear))
        {
            echo '<option value='.$loopYear.'>'.$loopYear.'</option>';
            $loopYear++;
            //break;
        }
         echo '<option selected value='.$currentYear.'>'.$currentYear.'</option>';
        ?>
    </select>
</p>
			
			<p></p>
			
			
                        <form id="form" action="../send.php" method="post" >
					
			<div id="dynamic">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="0%">ID</th>
			<th width="30%">Data</th>
			<th width="30%">Kwota</th>
			<th width="40%">Rodzaj wydatku</th>
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
                        <th></th>
			
		</tr>
	</tfoot>
</table>
</div>
                       
<div class="spacer"></div>
			
<input id="newClient" type="button" class="groovybutton" value="Dodaj wydatek" />
</form>
<div id="users-contain" class="ui-widget">
<p>
<h4>Podsumowanie - rok:  <span class ="reportYear"><?php echo Date('Y') ?></span></h4>
<table id="reportTable" class="ui-widget ui-widget-content">
      <thead>
      <tr class="ui-widget-header ">
        <th class="">Rodzaj Wydatku</th>
        <th class="lastname">Kwota Wydatku [zł]</th>
      </tr>
      </thead>
      <tbody>

      </tbody>
</table>

</div>
</div></div>
<!--                        <button id="formSubmit">Submit</button>-->




<div id="dialog-confirm" title="Czy na pewno usunąć rekord?">
	
</div>
<div id="dialog-form" title="Edycja Wydatku">
<!--	<p class="validateTips">All form fields are required.</p>-->
	<form  id="clientForm" method="post" action="save.php">
	<fieldset>
            <legend>Edycja Wydatku </legend>
		<p>
			<input type="hidden" id="id" name="id" size="50px" />
		</p>
		<p>
			<label for="category">Rodzaj wydatku</label>
			<select name="category" id="category">
                        

                        </select>
		</p>
                <p>
			<label for="amount">Kwota wydatku</label>
			<input id="amount" name="amount" size="50px" class="text ui-widget-content ui-corner-all"/>
		</p>
 
<!--		<p>
			<label for="target">Dodatkowy Adres</label>
			<input type="checkbox" class="checkbox" name="target" id="target" />
		</p>-->
                
		
	</fieldset>
	</form>
</div>






                </div>
	</body>
</html>