Yii2 admin panel with Modular APIS 
==================================

YII2 Admin panel with Advance OAUTH2  modular based APIS.

This is YII2 advanced template based project that have modular apis & rich featured admin panel.

# How to install

1) Clone the repo
    
    git clone git@bitbucket.org:nadeem_se/yii2-admin-modular-api.git
    
2) Go into created project 
    
    cd yii2-admin-modular-api

3) Install dependencies 3.2, If you don't have composer installed on your computer then first install composer follow step 3.1

 3.1) Install composer on your local machine, follow the getcomposer.org. 
    
    
```
#!php

https://getcomposer.org/doc/00-intro.md
```

 
 3.2) If you already have installed composer then add asset plug that required by yii and run composer install
  

```
#!php

 composer global require "fxp/composer-asset-plugin:^1.2.0"
 composer install

```

 
  
4) Create a Database and update db configuration into common/config/main-local.php

     
```
#!php

'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=127.0.0.1;dbname=YOU_DB_NAME',
                'username' => 'DB_USERNAME',
                'password' => 'DB_PASSWORD',
                'charset' => 'utf8',
     ],
```

   
5) Run database migrations
    
    
```
#!php

./yii migrate --migrationPath=@app/migrations/mysql
```


6) Enjoy !!!


# Key features that this Repo has
 
1) OAUTH2 module to manage API security & clients(Front-end APPS) access level. for OAUTH2 we are using (https://github.com/nadeemse/yii2-oauth2-server) server.

2) For admin panel, we are using Creative Tim admin panel theme (http://www.creative-tim.com/product/paper-dashboard)

3) In admin console, you can assign specific roles to sub admins for that we are using RBAC(Role-based access control: http://www.yiiframework.com/doc-2.0/guide-security-authorization.html)

4) Admin panel & API are fully integrated with  email helper , that provides you option to send email by simply passing few param
    (new EmailHelper)->sendEmail($to, $cc, $subject, $template, $data);
    
5) mainly MYSQL database for this project but there is MongoDB option as well,
   For example, if you want to log APIS calls, user logs and another large amount of data then better to use MongoDB collections for that.
   
6) We have developed a nice media manager by using AWS S3

7) TODO: Need to write unit testing and Swagger.


# How to use MongoDB with this application
 Well it's really simple task, just follow these steps
 ## Un comment "mongodb" adapter from 
```
#!php

common/config/main-local.php
```

and add yii2 MongoDB extension into composer and run the composer update 


```
#!php

"yiisoft/yii2-mongodb": "~2.0.4"
```
  
# New migration for MySql
simply run this command in terminal ./yii migrate/create --migrationPath=@app/migrations/mysql migration_name

# How to create MongoDB collection

MongoDB collection is same as MySQL table for that first you have ti make sure that you have installed MongoDB properly I mentioned above and then simply run 
./yii mongodb-migrate/create --migrationPath=@app/migrations/mongodb migration_name


# How can I write a new API end point or new API module
Well, it's a really simple to create a new API module, you have to define the module in modules section under api/config/main.php 
 
 Example: 
 
 
```
#!php

'settings' => [
    'class' => 'api\modules\settings\Module'
 ],
```


 
and then create a folder same as name settings under modules/folder name, and define the entry point for that module. for reference check settings module under api/modules/settings

# How can I generate an Auth token 
Well, it's very easy and this project already provided scope based access management .

Example: 

ACTION : POST
URL : http://YOUR_API_END_POINT/v1/user/auth/token
REQUEST BODY: 
//Below information is for the DEMO purpose only, once you will install application then these scopes and credentials are available as a part of YII MIGRATION.

```
#!json
{
	"username": "api@nadeemakhtar.info",
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

# You can find Login, Signup, forgot password links below 



1: 
# Signup: http://YOUR_API_END_POINT/v1/user/session/signup
Request Data:



```
#!json

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


2: 
# Login: http://YOUR_API_END_POINT/v1/user/session/login
Request Data: 


```
#!json

{
	"email": "nadeemakhtar.se@gmail.com",
	"password": "admin123"
}
```


3: Forgot password: http://YOUR_API_END_POINT/v1/user/session/forgot-password
Request Data: 


```
#!json

{
	"email": "nadeemakhtar.se@gmail.com"
}
```


4: Profile link : http://YOUR_API_END_POINT/v1/user/account/profile?token=AUTH_APP_TOKEN
HEADER PARAM: customer-token: AUTH_CUSTOMER_TOKEN


## you can explore other routes by simply using this Repo, I Will write unit tests & Swagger documentation for better understanding.

## Where can I access admin panel application

Well simply go to http://YOUR_BASE_URL/backend and you will see the backend application in running form 

Credentials for back-end:

username/email: info@yii2admin.com
pass: yii2Admin

## Is this project allow multiple clients to access resources 

Yes !!! you can do that by simply having multiple clients.

## What if we will have multilingual requirements
You can manage your application by simply passing app-locale header and system will give you response in required language(if that language is implemented on back-end) 


```
#!json
app-locale:en
```

## What if we are operating our app in different timezone  
You can pass app-tz header and the system will automatically pick your application/client time zone.


```
#!json
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