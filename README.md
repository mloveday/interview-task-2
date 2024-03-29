# interview-task-2
Technical test using Symfony 4, Doctrine, MySQL, Redis, RabbitMQ, Twilio and Vagrant.

Allows an SMS to be sent via a form.

## Usage
* Install VirtualBox and Vagrant
* Create a file, `.env.local`, in the symfony directory. Add the following keys and appropriate values: `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_SENDER_NUMBER`, `RECIPIENT_PHONE_NUMBER`
* Navigate to the `vagrant` directory and run `vagrant up`
* To start the sms consumer, ssh into the `interview-task-2` vagrant box (`vagrant ssh interview-task-2`), navigate to `/vagrant/interview-task-2/symfony` and run `php bin/console rabbitmq:multiple-consumer sms`
* To send a message, make a GET request (or navigate in your browser) to `http://localhost:8000`

## Completed Functionality
* Send an SMS to any number using a GET request (Queues messages with RabbitMQ)
* Rate limit requests to 1 per 15 seconds (Uses Redis)
* Serve a page with a form to enter a message and phone number
* On submitting the form (via a send button), queue the message to be sent
* Validation of requests (limit sms body to 140 chars, limit recipient to UK mobile number)
* Store all messages sent (body, sender, timestamp)
* Serve a page with a list of all SMS messages sent by the system, ordered by newest first
## To do
* Error handling
* Store & update the status of the SMS (queued, sent, failed). Note this will update after the initial message is sent (in progress)
* Create a user sign-up & login
* Restrict sending SMS to signed-in users
* Test it - read up on best practises for RabbitMQ & Rate limiting tests first
* Run the tests in Travis and display results in Github