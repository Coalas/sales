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

	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
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
       require_once('config.php');
       $models = Doctrine_Core::loadModels('models');
       if(isset ($_GET['id'])) {
       $q=Doctrine_Query::create()
           ->select("h.idhouses")
               ->from("House h")
               ->where("h.idhouses=?",intval($_GET['id']))
               ->fetchOne();
        
         $target = ($q->target == 1)? "checked":"";
           
       }
        echo "<form class=\"cmxform\" id=\"signupForm\" method=\"post\" action=\"save.php\">";
	echo "<fieldset>
	<legend>Validating a complete form</legend>
                <p>
			<input type=\"hidden\" id=\"id\" name=\"id\" size=\"50px\" value=\"".$q->idhouses."\"/>
		</p>
		<p>
			<label for=\"name\">Nazwa</label>
			<input id=\"name\" name=\"name\" size=\"50px\" value=\"".$q->name."\"/>
		</p>
		<p>
			<label for=\"city\">Miejscowość</label>
			<input id=\"city\" name=\"city\" size=\"50px\" value=\"".$q->city."\"/>
		</p>
		<p>
			<label for=\"zipCode\">Kod Pocztowy</label>
			<input id=\"zipCode\" name=\"zipCode\" value=\"".$q->zipCode."\"/>
		</p>
		<p>
			<label for=\"street\">Ulica</label>
			<input id=\"street\" name=\"street\" size=\"50px\" value=\"".$q->street."\"/>
		</p>
		<p>
			<label for=\"tel\">Telefon</label>
			<input id=\"tel\" name=\"tel\" value=\"".$q->tel."\"/>
		</p>
		<p>
			<label for=\"email\">Email</label>
			<input id=\"email\" name=\"email\" size=\"50px\"value=\"".$q->email."\"/>
		</p>
                <p>
			<label for=\"www\">www</label>
			<input id=\"www\" name=\"www\" size=\"50px\"value=\"".$q->www."\"/>
		</p>
		<p>
			<label for=\"target\">Organizator koncertów</label>
			<input type=\"checkbox\" class=\"checkbox\" id=\"target\" name=\"target\" ".$target." value=\"".$q->target."\"/>
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
