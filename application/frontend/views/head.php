<?php
set_time_limit(0);

$this->output->set_header("HTTP/1.0 200 OK");
$this->output->set_header("HTTP/1.1 200 OK");
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");

// Check User Login in Session
if($this->Page->getSession("intUserId") == '')
{
	redirect('', 'location');
}
else
{
	$c = $this->Page->getRequest("c");
	$m = $this->Page->getRequest("m");

	
	/*if(strtolower($c) != strtolower($this->Page->getSession("strUserType")))
	{
		show_404();
	}*/
	

	$intUserId		=	$this->Page->getSession("intUserId");	
	
	// Set UserSearch
    /*
	if($this->Page->getSession("UserSearchSet") == '')
	{
		$arrUserSearch	=	$this->Module->getUserSearch($intUserId);
		
		if(count($arrUserSearch)>0)
		{
			$arrUserSearch = unserialize($arrUserSearch[0]['params']);
		
			foreach($arrUserSearch as $Key	=> $Value)
			{
				$this->Page->setSession($Key,$Value);
			}
		}	
		
		$this->Page->setSession("UserSearchSet",1);
	}
    */
}

?>