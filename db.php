<?php
	//This file establishes a connection to the sqlite database
	//It also contains the different operations to be carried out on the database
	
		//The location in $path should be the absolute path to the database file
		$path = 'sqlite:absolute_path/bunq.db';
		$connection = new PDO($path) or die("Cannot Connect to Database");
		
		//This function creates a new thread for a new conversation between 2 members and returns the thread_id
		function newThread($member1_id, $member2_id)
		{
			$query=sqlite_exec($this->connection,"INSERT INTO thread(member1_id, member2_id, date_created) VALUES($member1_id, $member2_id, NOW())");
			return sqlite_last_insert_rowid($this->connection);
		}
		
		//This function inserts a new message into the database
		function postNewMessage($user_id, $thread_id, $message)
		{
			$query=sqlite_exec($this->connection, "INSERT INTO message(thread_id, user_id, message, date) VALUES($thread_id, $user_id, $message, NOW())");
		}
		
		//This function returns the name of a user attached to a user_id
		function loadUser($user_id)
		{
			$query=sqlite_query($this->connection, "SELECT name FROM user WHERE user_id='$user_id'");
			return $query;
		}
		
		//This function returns a list of existing conversations for the user and replaces the user_id with names
		function loadThreads($user_id)
		{
			$query=sqlite_query($this->connection, "SELECT member1_id, member2_id, date_created FROM thread WHERE '$user_id' in (member1_id, member2_id) AND valid='yes' ORDER BY thread_id DESC");
			while ($row = sqlite_fetch_array($query))
			{
				$row[0]=$this->loadUser($row[0]);
				$row[1]=$this->loadUser($row[1]);
			}
			return $row;
		}
		
		//This function returns all the messages contained in a conversation and replaces user_id with the users name
		function loadMessages($thread_id)
		{
			$query=sqlite_query($this->connection, "SELECT user_id, message, date FROM message WHERE thread_id='$thread_id' ORDER BY message_id ASC");
			while ($row = sqlite_fetch_array($query))
			{
				$row[0]=$this->loadUser($row[0]);
			}
			return $row;
		}
		
		//This method changes a threads validity from yes to no, hence giving a user a perception of deletion
		function deleteThread($thread_id)
		{
			$query=sqlite_exec($this->connection, "UPDATE thread SET valid ='no' WHERE thread_id='$thread_id'");
		}
?>