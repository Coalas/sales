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
        <link type="text/css" href="../media/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<script type="text/javascript" language="javascript" src="../media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../media/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../media/js/jquery.validate.js"></script>
        <script type="text/javascript" src="../media/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" charset="utf-8">
var oTable;
var gaiSelected =  [];
var aPos;

$(document).ready(function() {

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
// validate signup form on keyup and submit
	$("#emailForm").validate({
		rules: {
			subject: "required",
			emailbody: "required"

		},
		messages: {
			subject: "Wpisz Temat wiadomości",
			emailbody: "Wpisz treść wiadomości"

		}
	});

} ); //ready
tinyMCE.init({
		// General options
		mode : "exact",
		elements : "emailbody",
		theme : "advanced",
		skin : "o2k7",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "../media/css/style.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../media/js/lists/template_list.js",
		external_link_list_url : "../media/js/lists/link_list.js",
		external_image_list_url : "../media/js/lists/image_list.js",
		media_external_list_url : "../media/js/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
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
<p>
<div id="dynamic">
 <?php
       require_once("../config.php");
       $models = Doctrine_Core::loadModels(MODELS_PATH);
      if(isset ($_GET['id'])) {
       $q=Doctrine_Query::create()
           ->select("e.*")
               ->from("Email e")
               ->where("e.idemails=?",intval($_GET['id']))
               ->fetchOne();

         //$target = ($q->target == 1)? "checked":"";

       }
       $text = stripslashes($q->body);
        echo "<form class=\"\" id=\"emailForm\" method=\"post\" action=\"save.php\">";
	echo "<fieldset>
	<legend>Edycja Wiadomości:</legend>
                <p>
			<input type=\"hidden\" id=\"id\" name=\"id\" size=\"50px\" value=\"".$q->idemails."\"/>
		</p>
		<p>
			<label for=\"subject\">Temat</label>
			<input id=\"subject\" class=\"text ui-widget-content ui-corner-all\" name=\"subject\" size=\"50px\" value=\"".$q->subject."\"/>
		</p>
                <p>
                <textarea id=\"emailbody\" name=\"emailbody\" rows=\"15\" cols=\"80\" style=\"width: 80%\">
		&lt;p&gt;
		".$text."
		&lt;/p&gt;
	</textarea>

                </p>
		<p>
		<br/>	<input class=\"groovybutton\" type=\"submit\" value=\"Zapisz\"/>
		<input id=\"Cancel\" type=\"button\" class=\"groovybutton\" value=\"Anuluj\" onClick=\"location.href='index.php'\" />
                </p>
	</fieldset>
</form>";
                //$q->free();
        ?>
<div class="right">
</div>
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
