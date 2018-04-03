# chat-backend

I used 3 abstract tables having the following structure:

1) user
user_id| name
-------|------
       |

2)thread
thread_id| member1_id | member2_id | date_created| valid 
---------|------------|------------|-------------|-------
         |            |            |             |       

3)message
message_id| thread_id | user_id | message|  date
----------|-----------|---------|--------|--------
          |           |         |        |        


Sample of json to send a message:
{
	"request_id":1,
	"sender_id":"001",
	"recipient_id":"002",
	"thread_id":"012",
	"message":"Hello there",
}

I also assumed that the chat application has a flow like whatsapp:

Open application->View threads->Click on a thread->View messages->send a new message
OR
Open application->send new message->creates a new thread->posts the message
