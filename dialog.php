<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link type="text/css" href="media/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="media/js/jquery.js"></script>
	<script type="text/javascript" src="media/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() {
							$(this).dialog("close");
						},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});

				// Dialog Link
				$('#dialog_link').click(function() {
					$('#dialog').dialog('open');
					return false;
				});
                                $('.modalForm').click(function() {
                                    
                                    
                                    //alert($(this).attr('id'));
                                    
                                }


                            );

            });
            
        </script>
    </head>
    <body>
        <!-- ui-dialog -->
		<div id="dialog" title="Dialog Title">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		</div>
        <p><a href="#" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-newwin"></span>Open Dialog</a></p>
        

<?php
        require_once('config.php');
        $models = Doctrine_Core::loadModels('models');
       
        $q=Doctrine_Query::create()
           ->select("*")
               ->from("House h")
               ->where("h.idhouses=1")
               ->fetchArray();

         //$target = ($q->target == 1)? "checked":"";
         echo ("<a class=\"modalForm\" href=\"../edit.php\"><img border=\"0\" src=\"media/images/ico.edit.gif\" id=1\"/>");
        
        ?>
    </body>
</html>
