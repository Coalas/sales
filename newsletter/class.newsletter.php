<?php

class newsletter{
    /**
     * Number of maximum e-mails sent in one session. 
     * This setting is ussefull to not be taged ny the server as a spam sender.
     */
    var $MaxMails       = '40';
    
    /**
     * Number in seconds that the script will run. Set 5s less then the php config to avoid Maximum execution error.
     */
    var $MaxExecutionTime    = '55';
    
    
    /**
     * The table name where the mails are saved
     */
    var $MysqlTableName       = 'newsletter_queue';    
    
    /**
     * Mysql Object
     */
    var $mysqlObj;
    
    /**
     * phpMailer Object
     */
    var $MailObj;
    
    /**
     * Error Message.
     */
    var $errorMsg;
    
    /**
     * Senders Array
     */
    var $senders=array();
    
    /**#@+
     * @access private 
     * DO NOT MODIFY BELOW THIS LINE ...
     */
    var $m_Start = 0.0;
    var $emailSent = 0;
    
    /**
     * Constructor      
     */
    function newsletter(){  
    	$this->m_Start = $this->GetMicrotime();
    }    
    
    function addMysqlObg($mysql){
    	$this->mysqlObj=$mysql;  
    }
    
	function GetMicrotime(){
		list($micro_seconds, $seconds) = explode(" ", microtime());
		return ((float)$micro_seconds + (float)$seconds);
	}
	
	function GetTime($Decimals = 2){
		return number_format($this->GetMicrotime() - $this->m_Start, $Decimals, '.', '');
	}		   
    
    
    /**
     * Ads a new mail in the queue Table
     *
     * @param array $params
     * @return bool
     */
    function addMail($params){
    	$data=array('method'   		=> ( isset($params['method']) )    	   ? $params['method']   	 : 'mail',
    				'From'     		=> ( isset($params['From']) )     	   ? $params['From']     	 : 'root@localhost',
    				'FromName' 		=> ( isset($params['FromName']) ) 	   ? $params['FromName'] 	 : 'Root Account',
    				'Host'     		=> ( isset($params['Host']) )      	   ? $params['Host']     	 : 'localhost',
    				'SMTPAuth' 		=> ( isset($params['SMTPAuth']) ) 	   ? $params['SMTPAuth'] 	 : true,
    				'Username' 		=> ( isset($params['Username']) ) 	   ? $params['Username'] 	 : 'root@localhost',
    				'Password' 		=> ( isset($params['Password']) )  	   ? $params['Password'] 	 : '',
    				'recepientMail' => ( isset($params['recepientMail']) ) ? $params['recepientMail'] : false,
    				'recepientName' => ( isset($params['recepientName']) ) ? $params['recepientName'] : '',
    				'subject'       => ( isset($params['subject']) )       ? $params['subject']       : false,
    				'body'          => ( isset($params['body']) )          ? $params['body']          : false,
    				'ContentType'   => ( isset($params['ContentType']) )   ? $params['ContentType']   : 'text/plain',
    				'priority'      => ( isset($params['priority']) )      ? $params['priority']      : '3',
    				'SendDate'      => ( isset($params['SendDate']) )      ? $params['SendDate']      : time(),
    				);
    	$error=false;			
    	foreach ( $data as $key=>$value ){
    		if ($value===false) {
    			$error=true;
    			$errorMsg="Cannot add Mail. Empty value for [$key]";
    		}
    	}
    	if ( $error===true ){
    		$this->errorMsg=$errorMsg;
    		return false;
    	} else {
    		if ( ($this->mysqlObj instanceof mysql) === false ) {    			
	    		$this->errorMsg='Could not find a mysql object. Please load one using addMysqlObg.';
	    		return false;
    		} else {
    			$insertAttempt=$this->mysqlObj->record_insert($this->MysqlTableName,$data);
    			if ($insertAttempt===true) return true;
    			else {    			
		    		$this->errorMsg='SQL ERROR :'.$this->mysqlObj->error_desc;
		    		return false;    				
    			}
    		}
    	}	
    }
    
    /**
     * Sends mails from queue based on the config
     * @param array $params
     * @return bool
     */
    function Sendmail($params=array()){
		$parameters['rowCount']=$this->MaxMails; # No of rows returned
		$parameters['sortColumn']='priority'; # No of rows returned
		$mails=$this->mysqlObj->list_table( $this->MysqlTableName, false , $parameters );  

		if ( is_array($mails) && count($mails)>0 ){	
			if (class_exists('PHPMailer')) {
				$this->MailObj=new PHPMailer();
			} else {
	    		$this->errorMsg='Class PHPMailer not defined. Include the class file.';
	    		return false;			
			}
			
			foreach ( $mails as $mail ){
				$time=$this->GetTime();
				if ($time>$this->MaxExecutionTime) return true;
				else {

					if ($mail['method']=='mail') {
						$this->MailObj->IsMail();	
					} else {
						if (empty($mail['From'])) {
							$this->errorMsg='No sender [From] was defined for this mail.';
				    		return false;
						}elseif (empty($mail['Host'])) {
							$this->errorMsg='No sender [Host] was defined for this mail.';
				    		return false;							
						} else {
							if ($mail['SMTPAuth']=='true') {	
								$this->MailObj->IsSMTP();		
								$this->MailObj->Host = $mail['Host'];  // specify main and backup server							
								if (empty($mail['Username'])) {
									$this->errorMsg='No sender [Host] was defined for this mail.';
						    		return false;											
								} elseif (empty($mail['Password'])) {
									$this->errorMsg='No sender [Host] was defined for this mail.';
						    		return false;										
								} else {
									$this->MailObj->SMTPAuth = true;     // turn on SMTP authentication							
									$this->MailObj->Username = $mail['Username'];  // SMTP username
									$this->MailObj->Password = $mail['Password']; // SMTP password
								}	
							}							
						}
					}	
					
					$this->MailObj->From = $mail['From'];
					$this->MailObj->FromName = $mail['FromName'];
					
					$this->MailObj->AddAddress($mail['recepientMail']);
					$this->MailObj->AddReplyTo($mail['From'], $mail['FromName']);
					
					$this->MailObj->WordWrap = 50; // set word wrap to 50 characters
					if ($mail['ContentType']=='text/html') $this->MailObj->IsHTML(true);       // set email format to HTML
					
					$this->MailObj->Subject = $mail['subject'];
					$this->MailObj->Body    = $mail['body'];
					
					if(!$this->MailObj->Send()) {
						$this->errorMsg=$this->MailObj->ErrorInfo;
						return false;
					} else {
						$this->emailSent++;
						$this->mysqlObj->record_delete( $this->MysqlTableName, " newsletterQID='{$mail['newsletterQID']}' ");  
					}
					
					// Clears the adreses loaded ( thank you Jim Bell <jim@jimbellhq.com> )
					$this->MailObj->ClearAddresses();
					$this->MailObj->ClearAllRecipients();
					$this->MailObj->ClearReplyTos();					
				}
			}
		}   
		return true; 	    	
    }
}

?>