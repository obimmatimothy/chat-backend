<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once "json.php";
	require_once "newrequest.php";
	//$details retrieves the json from HTTP. can be POST or GET
	//Depends on how the json is transferred from the client
	$details= $_POST['json'];
	
	$jsonObject = new JSON();
	//The Json is decoded in the json class
	$jsonObject->processJSON($details);
	$request = new newRequest($jsonObject);
	//Ensures that all the required data for specific request is supplied by the json
	if(!empty($jsonObject->error))
	{
		$jsonObject->returnJSON($jsonObject->error);
	}
	//Request to send a new message
	elseif($jsonObject->request_id==1)
	{
		$request->postMessage();
	}
	//Request to view all threads
	elseif($jsonObject->request_id == 2)
	{
		$request->loadThreads();
	}
	//Request to view all messages in a thread
	elseif($jsonObject->request_id==3)
	{
		$request->loadMessages();
	}
	//Request to delete a thread
	elseif($jsonObject->request_id==4)
	{
		$request->deleteThread();
	}
?>