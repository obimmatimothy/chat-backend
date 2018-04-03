<?php
require_once "newrequest.php";
class JSON extends newRequest
{
	public $request_id;
	public $sender_id;
	public $recipient_id;
	public $thread_id;
	public $message;
	private $json_details;
	public $error =array();
	
	function __construct()
	{
		
	}
	
	//This function extracts the contents of the json received and parses them to class members
	/*This is done based on what type of valid request has been received.
	1 is a request to send a message
	2 is a request to display all threads
	3 is a request to display all messages for a thread
	4 is a request to delete a thread*/
	function processJSON($contents)
	{
		$this->json_details = json_decode($contents, true);
		$this->request_id = $this->json_details['request_id'];
		if( $this->request_id == null || $this->request_id<1 || $this->request_id>4)
		{
			$this->error['error']= "Invalid Request";
		}
		elseif($this->request_id==1)
		{
			$this->postMessageJSON();
		}
		elseif($this->request_id==2)
		{
			$this->loadThreadsJSON();
		}
		elseif($this->request_id==3)
		{
			$this->loadMessagesJSON();
		}
		elseif($this->request_id==4)
		{
			$this->loadMessagesJSON();
		}
	}
	
	//Ensures that the correct members needed to successfully post a message are present
	function postMessageJSON()
	{
		if($this->sender_id == null)
		{
			$this->error['error'] = "Invalid User ID";
		}
		else
		{
			$this->sender_id = $this->json_details['sender_id'];
		}
		
		if($this->recipient_id == null)
		{
			$this->error['error'] = "Invalid Recipient ID";
		}
		else
		{
			$this->recipient_id = $this->json_details['recipient_id'];
		}
		if($this->thread_id == null)
		{
			$this->error['error'] = "Invalid Thread ID";
		}
		else
		{
			$this->thread_id = $this->json_details['thread_id'];
		}
		
		if($this->message == null)
		{
			$this->error['error'] = "Invalid Message";
		}
		else
		{
			$this->message = $this->json_details['message'];
		}
	}
	
	//Parses the members needed to load a thread
	function loadThreadsJSON()
	{
		if($this->sender_id == null)
		{
			$this->error['error'] = "Invalid User ID";
		}
		else
		{
			$this->sender_id = $this->json_details['sender_id'];
		}
	}
	
	//parses the members needed to retrieve messages and deleta a thread
	function loadMessagesJSON()
	{
		if($this->sender_id == null)
		{
			$this->error['error'] = "Invalid User ID";
		}
		else
		{
			$this->sender_id = $this->json_details['sender_id'];
		}
		
		if($this->thread_id == null)
		{
			$this->error['error'] = "Invalid Thread ID";
		}
		else
		{
			$this->thread_id = $this->json_details['thread_id'];
		}
	}
	
	function __destruct()
	{
		
	}
}
?>