# QDVisitorReception

A quick and dirty visitor registration system to use on some sort of tablet at the reception desk.

This thing is written in HTML, CSS, and PHP with the mysqli extension.

![afbeelding](https://user-images.githubusercontent.com/10923347/201535004-2b0f41f9-5b35-4420-8af8-a43ab2e9d4f6.png)
You'll be greeted by a choice between employee or visitor.

![afbeelding](https://github.com/user-attachments/assets/a8b8006f-eb09-4f99-b121-0592d868c0ef)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535043-6e91eb8b-a858-47fd-a5eb-6393b7c1d2be.png)
At the employees page, employees can indicate whether they're present or not.
They can tap the Yes/No button, and it'll change to Yes or No immediately.
This assumes everyone at the organization is a grown up.
Before entering the employees page, you must type in a PIN code.

![afbeelding](https://user-images.githubusercontent.com/10923347/201535202-d5db23c3-f890-49e7-8bb0-aaa0520f06b3.png)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535192-485823e0-3431-4372-a2e0-0b9f7d7c7b75.png)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535218-7b34e191-991a-4241-a498-eb748fe82048.png)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535225-7d8e21f5-ffb7-4301-a46e-8b3e3c71067a.png)
Visitors are able to enter their name, and get registered.

![afbeelding](https://user-images.githubusercontent.com/10923347/201535264-29413e10-da5c-47f6-be39-2bd4b6290cd0.png)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535270-936cf452-2c73-4987-bf9d-a89365d9a014.png)
![afbeelding](https://user-images.githubusercontent.com/10923347/201535272-a1c30837-5728-4238-b8c0-3256d3d5affa.png)
Unless your organization is Hotel California, visitors can actually leave.

![afbeelding](https://user-images.githubusercontent.com/10923347/201535311-b09fdf3b-5ffe-4597-87ba-8c7c08290366.png)
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
