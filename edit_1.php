<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" media="screen" href="media/css/screen.css" />

        <script src="media/js/jquery.js" type="text/javascript"></script>
        <script src="media/js/jquery.validate.js" type="text/javascript"></script>
        <script type="text/javascript" src="media/js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
//$.validator.setDefaults({
//	submitHandler: function() { alert("submitted!"); }
//});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

	// validate signup form on keyup and submit
	$("#signupForm").validate({
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
		}
	});

	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "elm2",
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
		content_css : "../media/css/demo_page.css",

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
 
});
</script>
 <style type="text/css">
    #signupForm { width: 670px; }
    #signupForm label.error {
            margin-left: 10px;
            width: auto;
            display: inline;
    }
    #newsletter_topics label.error {
            display: none;
            margin-left: 103px;
    }
        </style>
    </head>
    <body>
        <?php
       require_once("config.php");
       $models = Doctrine_Core::loadModels('models');
       if(isset ($_GET['id'])) {
       $q=Doctrine_Query::create()
           ->select("e.*")
               ->from("Email e")
               ->where("e.idemails=?",intval($_GET['id']))
               ->fetchOne();
        
         //$target = ($q->target == 1)? "checked":"";
           
       }
        echo "<form class=\"cmxform\" id=\"signupForm\" method=\"post\" action=\"save.php\">";
	echo "<fieldset>
	<legend>Validating a complete form</legend>
                <p>
			<input type=\"hidden\" id=\"id\" name=\"id\" size=\"50px\" value=\"".$q->idemails."\"/>
		</p>
		<p>
			<label for=\"name\">Temat</label>
			<input id=\"name\" name=\"name\" size=\"50px\" value=\"".$q->subject."\"/>
		</p>
                <p>
                <textarea id=\"elm2\" name=\"elm2\" rows=\"15\" cols=\"80\" style=\"width: 80%\">
		&lt;p&gt;
		".$q->body."
		&lt;/p&gt;
	</textarea>

                </p>
		<p>
			<input class=\"submit\" type=\"submit\" value=\"Zapisz\"/>
		</p>
	</fieldset>
</form>";
                //$q->free();
        ?>

    
    </body>
</html>
