# interview-task-2
Technical test using Symfony 4, Doctrine, MySQL, Redis, RabbitMQ, Twilio and Vagrant.

Allows an SMS to be sent via a form.

## Usage
* Install VirtualBox and Vagrant
* Navigate to the `vagrant` directory and run `vagrant up`
* To start the sms consumer, ssh into the `interview-task-2` vagrant box (`vagrant ssh interview-task-2`), navigate to `/vagrant/interview-task-2/symfony` and run `php bin/console rabbitmq:consumer sms`

## Completed Functionality
* Send a predefined SMS to a predefined number using a GET request (Queues messages with RabbitMQ)
* Rate limit requests to 1 per 15 seconds (Uses Redis)
## To do
* Serve a page with a form to enter a message and phone number
* On submitting the form (via a send button), queue the message to be sent
* Store all messages sent (body, sender, timestamp, status)
* Store & update the status of the SMS (queued, sent, failed). Note this will update after 
* Serve a page with a list of all SMS messages sent by the system, ordered by newest first
* Create a user sign-up & login
* Restrict sending SMS to signed-in users