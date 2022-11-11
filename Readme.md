# QDVisitorReception
A quick and dirty visitor registration system to use on some sort of tablet at the reception desk.

This thing is written in HTML, CSS, and PHP with the mysqli extension.

## configuration.php
Rename the ```configuration.php.default``` file to ```configuration.php```.

## Logo
In ```configuration.php``` you can set the name of the logo you wish to replace the placeholder with. You'll have to name, create, and insert the logo yourself in the public folder.

As a guideline, the height shouldn't be higher than 220 pixels, no wider than 100 pixels, and the background should be transparent.

## Privacy e-mail address
In ```configuration.php``` you can set the e-mail address where users can come in contact with your organisation's data protection officer for GDPR related questions and/or "purge me from your memories and databanks" requests.
If your organisation doesn't have a data protection officer yet, you're all going to EU jail, where you'll be tortured to death by woodworking activities, conjugal visits by hired service people, and cake baking.

## Reception page
The receptionist can visit the /reception page to see current visitors.

It's set to be secured to internal networks only. Just add another IP address in `reception/.htaccess` if you're hosting this internet facing.

So if your buildings' external IP address is 130.89.16.82, just add
```text
Require ip 130.89.16.82
```
between the RequireAny tag.

## MariaDB password
It's a good idea to change the default password for MariaDB first.

In ```docker-compose.yml```, ```init.sql```, and ```configuration.php``` find and replace the string ```changeme```.

## Install
You can either do Docker or Classic LAMP.

Which one will you choose?

### Docker
Then just run
```shell
docker compose up
```
mate.

### Classic LAMP
There's no hipster framework that gives you dependency hell and fails to install anyway.
Just git clone in your webserver folder and create a database.

#### Prerequisites for server
You're going to need:
* Apache 2.4 or higher
* PHP 8
* MariaDB or MySQL
* Git client

For example, on Debian, you install those like this:
```shell
apt install -y apache2 php mariadb-server mariadb-client libapache2-mod-php php-mysql git && mysql_secure_installation 
```

The setup should work on CentOS, Arch, or even Windows too, but I couldn't be bothered to test that hypothesis.

#### Installing
Login as root.

Then you can do:
```shell
mysql < ./init.sql
```

#### Deployment
Files in the ```public``` directory are public facing.

Edit your Apache config to reflect that situation.

## Contributing
Just make some pull request and I'll probably hit the "Merge" button.

Or create an issue and roast this project and/or me as harshly as you can.

## License
This project is licensed under The Unlicense - see the ```LICENSE``` file for details.
