# QDVisitorReception

A quick and dirty visitor registration system to use on some sort of tablet at the reception desk.

This thing is written in HTML, CSS, and PHP with the mysqli extension.

![afbeelding](https://github.com/user-attachments/assets/3fde3578-f8f9-4810-97c8-1f8afb507dc3)
You'll be greeted by a choice between employee or visitor.

![afbeelding](https://github.com/user-attachments/assets/a8b8006f-eb09-4f99-b121-0592d868c0ef)
![afbeelding](https://github.com/user-attachments/assets/162c7aac-7067-403f-bf40-1ea1c36669f8)
At the employees page, employees can indicate whether they're present or not.
They can tap the Yes/No button, and it'll change to Yes or No immediately.
This assumes everyone at the organization is a grown up.
Before entering the employees page, you must type in a PIN code.

![afbeelding](https://github.com/user-attachments/assets/923b88c9-ae95-4b0c-9baf-1dec9fb551ed)
![afbeelding](https://github.com/user-attachments/assets/688378fb-7646-452c-b0b2-9781d8feb97c)
![afbeelding](https://github.com/user-attachments/assets/f19c9c82-fbf9-4470-802e-308a06cf085e)
![afbeelding](https://github.com/user-attachments/assets/76cac5b7-5968-474b-b75c-99b4f8db8254)
Visitors are able to enter their name, and get registered.

![afbeelding](https://github.com/user-attachments/assets/4047f0cf-32ea-4086-a3b9-06c015d8902d)
![afbeelding](https://github.com/user-attachments/assets/70053f21-8736-48ee-9fb6-fab88c11ded8)
![afbeelding](https://github.com/user-attachments/assets/3259b70c-8689-4ece-9693-8494bfb02973)

Unless your organization is Hotel California, visitors can actually leave.

![afbeelding](https://github.com/user-attachments/assets/1094dd13-13c6-4371-966c-6736a88cfe2b)
Receptionists can administer visitors and employees on the /reception page.

## .env

Rename ```.env.dist``` to ```.env``` to create the configuration file.

### MariaDB password

In ```.env```, change the MariaDB password called ```changeme```.

### Logo

In ```.env``` you can set the name of the logo you wish to replace the placeholder with. You'll have to name, create, and insert the logo yourself in the public folder.

As a guideline, the height shouldn't be higher than 220 pixels, no wider than 100 pixels, and the background should be transparent.

### Privacy e-mail address

In ```.env``` you can set the e-mail address where users can come in contact with your organization's data protection officer for GDPR related questions and/or "purge me from your memories and databanks" requests.
If your organization doesn't have a data protection officer yet, you're all going to EU jail, where you'll be tortured to death by woodworking activities, conjugal visits by hired service people, and cake baking.

### PIN code for employees

Before entering the Employee page, you'll be greated with a numpad to enter a PIN code.

In ```.env```, you can change the PIN code.

## Reception page

The receptionist can visit the /reception page to see current visitors.

It's set to be secured to internal networks only. Just add another IP address in `reception/.htaccess` if you're hosting this internet facing.

So if your buildings' external IP address is 130.89.16.82, just add

```ini
Require ip 130.89.16.82
```

between the RequireAny tag.

## Install

You can either use Docker or Classic LAMP.

Which one will you choose?

### Docker

Just run

```shell
docker compose up
```

mate.

### Classic LAMP

Git clone in your webserver folder and create a database.

#### Prerequisites for server

You're going to need:

* Apache 2.4
* PHP 8
* MariaDB 10
* Composer 2
* Git

For example, on Debian, you install those like this:

```shell
apt install -y apache2 php composer mariadb-server mariadb-client libapache2-mod-php php-mysql git && mysql_secure_installation 
```

#### Installing

##### dotenv install

Install dotenv by doing

```shell
composer install
```

##### Database install

```shell
sudo mysql < ./init.sql
sudo mysql < echo "USE mysql; UPDATE user SET PASSWORD = PASSWORD('$MARIADB_PASSWORD') WHERE user = 'qdvr' AND host = '%'; FLUSH PRIVILEGES;"
```

#### Deployment

Files in the ```public``` directory are public facing.

Edit your Apache config to reflect that situation.
Make damn sure no one can see the ```.env``` file but you.

## Using other platforms

### Apache

You can use something else than Apache, but it'll mean you'll have to secure ```/reception``` some other way.

### PHP 8

PHP 5 and PHP 7 could probably work fine too, haven't tested that.

### MariaDB

MySQL or Oracle Datebase will probably work fine.

You could probably easily convert the database to PostgreSQL, Microsoft SQL, IBM Db2, etc. since it's not that complicated of structure. There aren't even foreign keys or procedures.

### Linux

There's no reason why BSD or Windows wouldn't work, I just don't personally use those platforms for hosting usually.

### Browser from current year

Don't use Internet Explorer, idiot.

## Contributing

Just make some pull request, and I'll probably hit the "Merge" button.

Or create an issue and roast this project and/or me as harshly as you can.

## License

This project is licensed under The Unlicense - see the ```LICENSE``` file for details.
