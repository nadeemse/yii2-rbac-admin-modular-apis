Yii2 admin panel with Modular APIS 
==================================

YII2 Admin panel with Advance OAUTH2  modular based APIS.

This is YII2 advanced template based project that have modular apis & rich featured admin panel.

# How to install

1) Clone the repo
    
    git clone https://github.com/nadeemse/yii2-rbac-admin-modular-apis.git
    
2) Go into directory created with this repo 
    
    cd yii2-admin-modular-api

3) Install dependencies 
	If you don't have composer installed on your computer then first install the composer by following link https://getcomposer.org/doc/00-intro.md
 
4) Install Yii2 assets dependencies by following command 
  
```
composer global require "fxp/composer-asset-plugin:^1.2.0"
```

5) now time to install third party packages by simply running command 

```
composer install
```

 
  
5.1) Create a new database and update db configuration into common/config/main-local.php, in my case db name is yii2Rbac.

     
```
'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=127.0.0.1;dbname=yii2Rbac',
                'username' => 'DB_USERNAME', // This is as per your mysql server configuration. 
                'password' => 'DB_PASSWORD', // This is as per your mysql server configuration 
                'charset' => 'utf8',
     ],
```

   
5.2) Now time to migrate all databases table and seed defult data. If you are using Ubunut / OS then run below command on your root directory For window user follow step (5.3)
    
```
./yii migrate --migrationPath=@app/migrations/mysql
```

5.3) If you are using window operating system then run command on your root directory of the project 
    
```
yii migrate --migrationPath=@app/migrations/mysql
```

6) Enjoy !!!


# Key features that this Repo has
 
1) OAUTH2 module to manage API security & clients(Front-end APPS) access level. for OAUTH2 we are using (https://github.com/nadeemse/yii2-oauth2-server) server.

2) For admin panel, we are using Creative Tim admin panel theme (http://www.creative-tim.com/product/paper-dashboard)

3) In admin console, you can assign specific roles to sub admins for that we are using RBAC(Role-based access control: http://www.yiiframework.com/doc-2.0/guide-security-authorization.html)

4) Admin panel & API are fully integrated with  email helper, That's provide an option to send email with CC, attachment and with HTML content. 

```
$to : to whom you want to send email
$cc: Array of emails to whom you want to send cc
$subject: String 
$template: html file that you want to use, in my case all emails files are under common/mail

(new EmailHelper)->sendEmail($to, $cc, $subject, $template, $data);
```

5) This applicaiton is using MYSQL database if you want to use mongoDB then you have to follow mongodb with yii2 documentaiton.
   
6) This module is ship with Amazon S3 media manager to mange images, videos and other files. 

7) TODO: Need to write unit testing and Swagger.


# How to use mongoDb with this application

You can use mongodb connection as well by following reference link https://github.com/yiisoft/yii2-mongodb.
 
Un comment "mongodb" adapter from 
```
common/config/main-local.php
```

And add yii2 MongoDB extension into composer and run the composer update 

```
#!php

"yiisoft/yii2-mongodb": "~2.0.4"
```
  
# New migration for MySql
Run the command root directory of your project under terminal ./yii migrate/create --migrationPath=@app/migrations/mysql migration_name

# How to create MongoDB collection

MongoDB collection creation is same as mysql table creation. Make sure that you have installed MongoDB properly I mentioned above and then run below command on your project root directory. 

```
./yii mongodb-migrate/create --migrationPath=@app/migrations/mongodb migration_name
```

# How can I write a new API end point or new API module
To create a new module, you have to define the module in file *api/config/main.php* in modules Array. for example if I want to create a new module *settings* then I need to define like below.

Example: 

```
'settings' => [
    'class' => 'api\modules\settings\Module'
],
```

And then create a folder with same name settings under api/modules, and define the entry point for that module. for reference check settings module under api/modules/settings

# How can I generate an Auth token 
To create a access token you have to send a POST request to below endpoint with given credentials. 

ACTION : POST
URL : http://YOUR_API_END_POINT/v1/user/auth/token
REQUEST BODY: 
//Below information is for the DEMO purpose only, these scopes and credentials are ship with YII MIGRATION.

```
{
	"username": "api@nadeemakhtar.info", // you can create your own credentials 
	"password": "#api",
	"client_id": "testclient",
	"client_secret": "testpass",
	"grant_type": "password",
	"scope": "account profile catalog root required-customer-token"
}
```


# How to access restrict resources/end points 
Once you have generated AUTH token then simply pass that token into endpoint URL with ?token=your_token and this will allow your application to access restrict resources.
This gives you unauthorised access error if your token scope is not matched with resource scope or resources access levels.

# IS this application provide me to manage backend access controls 
Yes, this application is using RBAC for back-end resources management, so you can restrict user permission to even on route level.
 
# Does this application Allow users to register and login 

Yes, We have integrated token based login system for Front-end Users as well. So it's very Easy signup/login/forgot-password/reset password.


# YOUR_API_END_POINT

This is application APIs endpoint, you have to create a virtual host and point it to api/web. 

# Signup API: http://YOUR_API_END_POINT/v1/user/session/signup

Send a POST request to v1/user/session/signup with required informaiton. 

```
{
  "email": "nadeemakhtar.se@gmail.com",
  "password": "admin123",
  "first_name": "Nadeem",
  "last_name": "Akhtar",
  "country": "9",
  "gender": 1,
  "amazing_offers": true,
  "occasional_updates": true,
  "dob": "2010-01-09"
}
```
 
# Login API: http://YOUR_API_END_POINT/v1/user/session/login

Send post request to above end point with email and password. this API will return you a account auth-key that you have to store in your header to get access on account related APIS, like profile, reset password, update profile information etc. 

```
{
	"email": "nadeemakhtar.se@gmail.com",
	"password": "admin123"
}
```


# Forgot password API: http://YOUR_API_END_POINT/v1/user/session/forgot-password

Send a post request to above link, system will send an email to provided email with reset password link. 

```
{
	"email": "nadeemakhtar.se@gmail.com"
}
```


# Profile link : http://YOUR_API_END_POINT/v1/user/account/profile?token=AUTH_APP_TOKEN

customer-token: This is the token that you will get once call login API. 

HEADER PARAM: customer-token: AUTH_CUSTOMER_TOKEN

**You can explore other routes by simply using this Repo, I am working on Unit tests & Swagger documentaiton. Will update soon.**

# Where can I access admin panel application

Create a virtual host and point it to backend/web and access it it browser. 

Credentials for back-end:

username/email: info@yii2admin.com
pass: yii2Admin

# Multiple clients to access resources 

You can define multiple clients and provide them scope to access APIS end point. 
Clients Like: Website, IOS APP, Android APP

# Multilingual
You can manage your application by simply passing app-locale header and system will give you response in required language(if that language is implemented on back-end) 


```
app-locale:en
```

# Multi Country & Timezones 
You can pass app-tz header and the system will automatically pick application given timezone.

```
app-tz:asia/dubai
```

If you need more information just drop me an email. 
### nadeemakhtar.se@gmail.com


DIRECTORY STRUCTURE
-------------------

```
 common
    config/              contains shared configurations
    helpers/             containes helpers classes like EmailHelper etc .    
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    widgets/             contains widgets like alert box, modelbox etc..
 api
    config/              contains api configurations
    core/                containes core override functionality
    modules/             contains modules and inner modules
    runtime/             contains files generated during runtime
    web/                 contains the entry script and Web resources
 console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
 backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
 vendor/                  contains dependent 3rd-party packages
 environments/            contains environment-based overrides
 tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
