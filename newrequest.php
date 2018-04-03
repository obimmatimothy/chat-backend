<?php
	require_once "json.php";
	require_once "db.php";
	class newRequest
	{
		private $dataobject;
		private $error = array();
		
		function __construct(JSON $object)
		{
			$this->dataobject=$object;
		}
	
		/*This function adds a new message to the database. 
		A thread is also created if this is the first time
		2 users are communicating
		*/
		function postMessage()
		{
			if($this->dataobject->thread_id==null)
			{
				$this->dataobject->thread_id=newThread($this->dataobject->sender_id, $this->dataobject->recipient_id);
			}
			$cleanMessage= $this->cleanMessage();
			postNewMessage($this->dataobject->sender_id, $this->dataobject->thread_id, $this->dataobject->recipient_id);
		}
		
		//This function removes excess whitespaces and prevents attacks from SQLInjection
		function cleanMessage()
		{
			trim($this->dataobject->message);
			return sqlite_escape_string($this->dataobject->message);
		}
		
		//This function returns a list of all active communications a user has 
		function loadThreads()
		{
			$threads = loadThreads($this->dataobject->sender_id);
			$this->returnJSON($threads);
		}
		
		//This function returns all messages in a conversation
		function loadMessages()
		{
			$messages = loadMessages($this->dataobject->thread_id);
			$this->returnJSON($messages);
		}
		
		//This function deletes a thread by altering its validity in the database
		function deleteThread()
		{
			deleteThread($this->dataobject->thread_id);
		}
		
		//This method converts the returned array into json format and outputs it to be processed on the client-side
		function returnJSON($results)
		{
			if(empty($results))
			{
				$results['error']="Unable to load details. Contact System Administrator";	
			}
			
			echo json_encode($results);
			
		}
		
		function __destruct()
		{
		
		}
		
	}
?>