# UltimateCRM
A quick and easy way to manage your clients, invoices and projects!

Master: [![Build Status](https://travis-ci.org/shivampaw/UltimateCRM.svg?branch=master)](https://travis-ci.org/shivampaw/UltimateCRM)

Develop: [![Build Status](https://travis-ci.org/shivampaw/UltimateCRM.svg?branch=develop)](https://travis-ci.org/shivampaw/UltimateCRM)

![UltimateCRM](http://i.imgur.com/KTLolK8.png)

### Features
* Super Admins (ID 1) can create and delete multiple admins
* Admins can create and manage clients
* Admins can create invoices and projects for clients
* Clients can view and pay invoice through Stripe integration
* Emails sent when a new admin or client account is created, a client invoice or project is created and a client invoice is paid.

## Requirements / Installation / Troubleshooting
Need help getting started? Here's where to look!
### Requirements
This CRM runs with Laravel 5.2 for which the requirements are as follows:
* PHP >= 5.5.9
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

### Installation
To install run the following commands in a working directory:
`git clone https://github.com/shivampaw/UltimateCRM.git`

You will then need to change your web server root to the public directory. Contact your host for help if you need it.

Now run `composer install` and make sure you have composer installed on your server!

Then setup your database and open the `.env.example` file. Rename this file to `.env` and enter details for your database, stripe and email integration.

Run `php artisan key:generate` from the root project folder.

Run `php artisan migrate` from the root project folder. This will create the database tables for you.

Now you can setup your Super Admin account by running `php artisan super_admin:create` which will walk you through creating the account.

You should then be able to access UltimateCRM easily!

### Troubleshooting
Found an error? [Open an issue](https://github.com/shivampaw/UltimateCRM/issues/new) and let us know! 
We will add common issues here for everyone to see easily!

## Contributing
If you would like to contribute to this project then please submit all pull requests to the `develop` branch.
All builds are checked with Travis CI.
Please ensure your coding standard matches PSR-2. You can do so by running the following commands:

#### Install PHP-CS-Fixer
`composer global require friendsofphp/php-cs-fixer`

#### Run Command
`php-cs-fixer fix PATH_TO_PROJECT_FILES --level=psr2 --fixers=-psr0`

## License
This project is open-sourced and licensed under the [MIT license](http://opensource.org/licenses/MIT).
