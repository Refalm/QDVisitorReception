# QDVisitorReception
A quick and dirty visitor registration system to use on some sort of tablet at the reception desk.

This thing is written in HTML, CSS, and PHP with the mysqli extension.

## Getting started
There's no hipster framework that gives you dependency hell and fails to install anyway.
Just git clone in your webserver folder and create a database.

### Prerequisites for client
The client will need a web browser.

The webinterface should work on the following browsers:
* Chromium 71 or later (or forks like Brave, Chrome, Edge, Opera, Vivaldi, etc.)
* Firefox 60 or later
* Safari 12 or later

Internet Explorer should work too, except for some emoji's not displaying correctly.

### Prerequisites for server
You're going to need:
* Some sort of webserver like Apache 2, nginx, or IIS
* PHP 7 or PHP 5
* MariaDB or MySQL
* Git client

For example, on Debian, you install those like this:
```
apt install -y apache2 php mariadb-server mariadb-client libapache2-mod-php php-mysql git && mysql_secure_installation 
```

The setup should work on CentOS, Arch, or even Windows too, but I couldn't be bothered to test that hypothesis.

### Installing
In the MariaDB console, create the database and user.

Or use PHPMyAdmin, who am I to judge?

Here's an example:
```
CREATE DATABASE `qdvrdb`;

USE `qdvrdb`;

CREATE TABLE `visitor` (`visitorname` varchar(123) NOT NULL, `visitormail` varchar(123) NOT NULL, `visitororg` varchar(123) NOT NULL, `host` varchar(123) NOT NULL, `arrivetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, `departtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `visitor` ADD UNIQUE KEY `visitorname` (`visitorname`);

CREATE TABLE `employee` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(128) NOT NULL, `present` bit(1) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

GRANT ALL PRIVILEGES ON qdvrdb.* TO qdvr@localhost IDENTIFIED BY "please change this";

DESCRIBE `visitor`;

DESCRIBE `employee`;
```

If you copy/pasted the above example, at least change the password.

### Deployment
Git clone in the webserver folder. That folder is ```/var/www/html``` on Debian, but it might be somewhere else on your server, so check where it is first.
Configure your webserver so it points to the ```public``` directory when someone accesses it.

Rename the ```configuration.php.default``` file to ```configuration.php```.

Edit the ```configuration.php``` file to reflect the database, user, and password.

For extra security, use password protection with the ```.htaccess``` file on the ```reception``` directory, which is described here: http://www.htaccesstools.com/articles/password-protection/

#### Logo
In ```configuration.php``` you can set the name of the logo you wish to replace the placeholder with. You'll have to name, create, and insert the logo yourself in the public folder.

As a guideline, the height shouldn't be higher than 220 pixels, no wider than 100 pixels, and the background should be transparent.

## Contributing
Just make some pull request and I'll probably hit the "Merge" button.

Or create an issue and roast this project and/or me as harshly as you can.

## License
This project is licensed under The Unlicense - see the ```LICENSE``` file for details.
