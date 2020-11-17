# CurrencyFair Test via Codeigniter framework

Support for Restful API using Codeigniter and Basic Auth

# Requirements
LAMP stack with php>=5.6

# Setup
1) Download the code and import the sql present in root by the name "currencyfair.sql"
2) Change database config in file application/config/database.php
3) Change base_url in file application/config/config.php
current -> $config['base_url'] = 'http://localhost/currencyfair/';


You can use [POSTMAN](https://www.getpostman.com/) or anything else for simulate API's
2 API's
1) GET -> http://localhost/currencyfair/getAuthToken
2) POST -> http://localhost/currencyfair/consumer

# Working:
## Message Consumption:
To post Consumer API, An auth token is required which uses basic auth with username:admin and password:admin123.
A token is generated which is valid for 5 minutes from the time of first creation.
Once, Auth token is recieved. Consumer API will require that auth token and user_id param(currently set as '1') as headers with below mentioned request params in content-type = JSON.

 `{
"userId": "1",
"currencyFrom": "EUR",
"currencyTo": "GBP",
"amountSell": 1000,
"amountBuy": 747.10,
"rate": 0.7471,
"timePlaced" : "24-JAN-18 10:27:44",
"originatingCountry" : "FR"
}`

## Message Processor
Takes the message from consumption API and saves it to database.

## Message frontend
Open BaseUrl of project, It will redirect to the frontend controller that shows the list of all transactions by a particular user in real time.


### For futher clarifications please find the images attached under folder screenshots.
