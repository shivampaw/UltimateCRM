# UltimateCRM
A quick and easy way to manage your clients, invoices and projects all on one web application made with Laravel!

Master: [![Build Status](https://travis-ci.org/shivampaw/UltimateCRM.svg?branch=master)](https://travis-ci.org/shivampaw/UltimateCRM)

Develop: [![Build Status](https://travis-ci.org/shivampaw/UltimateCRM.svg?branch=develop)](https://travis-ci.org/shivampaw/UltimateCRM)

![UltimateCRM](https://i.imgur.com/UMAIxfa.png)

### Features
* The super admin (ID 1) can create and delete multiple admins
* Admins can create and manage clients
* Admins can create invoices and projects for clients
* Clients can view and pay invoice through Stripe integration
* Emails sent when a new admin or client account is created, a client invoice or project is created and a client invoice is paid.

**If you have any feature requests then just [open an issue](https://github.com/shivampaw/UltimateCRM/issues/new) and let us know!**

## Requirements / Installation / Usage / Troubleshooting
Need help getting started? Here's where to look!
### Requirements
This CRM runs with Laravel 5.3 for which the requirements are as follows:
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

### Installation
To install run the following commands in a working directory:
`git clone https://github.com/shivampaw/UltimateCRM.git`

You will then need to change your web server root to the public directory. Contact your host for help if you need it.

Now run `composer install` and make sure you have composer installed on your server!

Then setup your database and open the `.env.example` file. Rename this file to `.env` and enter details for your site, database, stripe and email integration.

Run `php artisan key:generate` from the root project folder.

Run `php artisan migrate` from the root project folder. This will create the database tables for you.

Now you can setup your Super Admin account by running `php artisan super_admin:create` which will walk you through creating the account.

You also need to add a crontab with the following details: `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1` Edit the /path/to/artisan to your actual artisan path. Artisan is the file in the root directory of the project. You should be able to do this by logging into your server via SSH and running `crontab -e`. Then just paste the above line correctly. **This step is optional and only required if you want to use recurring invoices**.

You should then be able to access UltimateCRM easily!

### Usage
You can edit the .env to configure most of the settings the CRM uses.

If you want to edit the display of the "views" then you can do so by adding the files in the `resources/customViews/` directory.
For example, if you place a file in `resources/customViews/emails/invoices/new.blade.php` that file will be used when emailing the client about a new invoice instead of the default in `resources/views/emails/invoices/new.blade.php`. You can therefore edit all the views that come with UltimateCRM by default.

If you want to add a custom CSS file you can add in in the `public/css` directory and then load that file in your `app.blade.php` view - be sure to override the default one though!

### Troubleshooting
Found an error? [Open an issue](https://github.com/shivampaw/UltimateCRM/issues/new) and let us know! 
We will add common issues here for everyone to see easily!

## Contributing
If you would like to contribute to this project then please submit all pull requests to the `develop` branch.
All builds are checked with Travis CI.
Please ensure your coding standard matches PSR-2. You can do so by running the following commands:

#### Install PHP-CS-Fixer
This command will install `php-cs-fixer` which will be used to format the project to PSR-2 standards.

`composer global require friendsofphp/php-cs-fixer`

#### Run Command
Run the following command from the project root because it needs to load the .php_cs config file.

`php-cs-fixer fix`

This will format the project to PSR-2. Be sure to run this before committing and pushing any changes!

## License
This project is open-sourced and licensed under the [MIT license](http://opensource.org/licenses/MIT).
