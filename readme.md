# Challenge: MySQL

- Repository: `php-mysql-introduction`
- Type of Challenge: `Learning challenge`
- Duration: `3 days`
- Team challenge : `solo`

## Learning objectives
- Learn how to view and edit a db in a db manager
- Learn to write SQL queries
- Learn to make a Create, Read, Update & Delete (CRUD) system
- Learn to write a login and registration form
- Learn to manage login state

## Introduction
We've touched the basis of `PHP` now it's time to learn about his partner in crime, let's look at `MySQL`/`MariaDB` and what it does / how it works..

### What is the difference between MySQL and MariaDB?
![mariadb-vs-mysql.png](resources/mariadb-vs-mysql.png)

You will find that many articles use the terms MySQL and MariaDB interchangeably, but there are different databases. They do have a shared history, and are the same for 95%. 
This means in practice that most projects can change from one db to another with probably only minor problems. 
MySQL used to be open-source, until it was acquired by Oracle, when some of the original developers of MySQL forked it due to concerns over its acquisition by Oracle Corporation.
This fork was named "MariaDB", and is the new open source alternative for MySQL.
Technically, MySQL is an open-source database, but in practice, it no longer feels like it. Under Oracle's umbrella, MySQL now has proprietary, closed-source modules, which was one of the main controversial changes that drove the community in two camps.

Technically there is not much difference between both versions, but in the last years MariaDB has being making more progress on performance, where it now outclasses MySQL for most use cases.
To make the basic application is this exercise you will not notice a difference, but you can always [learn more about the differences](https://www.eversql.com/mariadb-vs-mysql/) between the vendors.

![mysqljoke.png](resources/mysqljoke.jpg)

## Install a database manager
Database managers are used to manage local and remote databases. They discover databases based on the Web server and provide the ability to connect to any of the databases residing in the network. They provide a handful of administrative functionalities such as managing tables, views and stored procedures, as well as run ad hoc queries.

DB managers connect to the database and display information from catalogs that are part of a database. DB managers can have a set of command-line parameters, which allow them to initiate features and functions external to the graphical user interface.

There are various free and paid programs for all OS systems, here is a list of some good tools to use, but feel free to experiment which program you like the best:

- [DB beaver](https://computingforgeeks.com/install-and-configure-dbeaver-on-ubuntu-debian/) A good and free to use tool that provides a smooth UI to do all basic operations to a large number of databases.
- [mysql workbench](https://www.linode.com/docs/databases/mysql/install-and-configure-mysql-workbench-on-ubuntu/
) Despite the name can also manage MariaDB. Can do really complex handling with the editor, but the UI feels slow and unresponsive in this coach his opinion.
- [intellij datagrip](https://www.jetbrains.com/datagrip/) From the same makers as PhpStorm this is a paying version that provides a very slick interface to manage your databases. Uses the same type of interface as PhpStorm. During your stay in BeCode you have a free license to this program if you want to test it out!

### What about PhpMyAdmin?
Many tutorials will recommend installing PhpMyAdmin on your server, which is a db manager written in PHP. It is really easy to use, just deploy the files on your web server and it works!

But: ***You should never deploy PhpMyAdmin on a production machine***

The program is know to be vulnerable to a variety of attacks, and needs to be patched regularly. Unless you automated this process changes are really high that you will not update the program fast enough for some bot to find your PhpMyAdmin and get access to all your databases on that machine!

This means that the hacker now can steal all your (customer) data, and even erase your data after he is done. There are many attack bots running on the internet that are looking for vulnerable installations to break into. 

You could place it behind a firewall or VPN but you still have a dangerous backdoor open if some attacker ever gets access to your network.

## The mission

### Step 1: Create a database
- Go to your local database manager
- Create a database, called `becode`
- Create a table, called `student`
- Give it the following structure:
    - `id` | Primary Key & Index | Auto Increment
    - `first_name`
    - `last_name`
    - `username`
    - `gender`
    - `linkedin` (not required)
    - `github` (not required)
    - `email` 
    - `preferred_language` *(use the `ISO 639-1` Codes, you can find them [here](https://www.constitution.org/lg/languagecode.html)*
    - `avatar` *(a fun picture of yourself or something you want to use as an avatar)*
    - `video` *(a youtube link to a music video you like)*
    - `quote` *(a quote you like)*
    - `quote_author` *(person who made the quote)*
    - `created_at` *(auto fills in the timestamp when you create an entry, lookup how to do this, hint:look for this column name)*

#### Some funny diversion (nice to have!)
- You could to get a picture from [belikebill](https://www.belikebill.ga/), fill in your details and generate a fun picture. Then upload it anywhere and enter the URL of the picture in the `avatar` column.

### Step 2: Connect to the database
Enter the following code into `connection.php`:

`````php

function openConnection() {
 // Try to figure out what these should be for you
 $dbhost    = "DB_HOST";
 $dbuser    = "DB_USER";
 $dbpass    = "DB_USER_PASSWORD";
 $db        = "DB_NAME";
 
 // Try to understand what happens here 
$pdo = new PDO('mysql:host='. $dbhost .';dbname='. $db, $dbuser, $dbpass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
 // Why we do this here
 return $pdo;
}
`````

You can find much more info how to work with PDO on [PHP the right way](https://phptherightway.com/#pdo_extension).

#### A story about mysql_connect, mysqli_connect and PDO.
If you are searching the internet for PHP tutorials how to connect to a database you will quickly discover that there are many ways of doing it. Be carefull not to mix them up, you cannot combine the different ways together. So choose one and stick with it!

The 3 methods you will probably find are:
- Mysql_connect: This method is outdated and should never be used. You might encounter this with old legacy code. Specific driver for the MariaDB and MySQL databases.
- Mysqli_connect: The updated version of the above method, with some more advanced features (that you do not need yet). Specific driver for the MariaDB and MySQL databases.
- PDO: PDO is a modern database connector that uses the same interface to connect to [more than 12 databases](https://www.php.net/manual/en/pdo.drivers.php#pdo.drivers). It is easy and safe to use but misses some advanced methods from mysqli.

My opinion is that PDO should be used by default, especially beginners, due to its versatility, general predictability and useful fetch modes.

If you want a more [detailed analyses](https://websitebeaver.com/php-pdo-vs-mysqli) I encourage you to read some more about this.

### Step 3: 
![Lets goooooo!!!](resources/rambo.jpeg)

- Create `index.php`, `insert.php`
- Include the `connection.php` file in both, but make sure your `PHP` code won't run if the connection file isn't included
- Create a form that allows you to fill in the table with your data in `insert.php`
- Make sure your form requires every column of the table to be filled
- Test by inserting your data
- Check your database program to see if all your data is correctly entered into the database

#### Unknown driver error
If you get an error about unknown drivers, you probably still need to install the php-mysql extension. This is the "glue" between MySQL and PHP.

run `sudo apt-get install php-mysql`

### Step 4:
> **WARNING: If you continue to this step and your code is buggy/not functional, you will tamper with online resources which will affect everyone. So test your code for bugs!**

Ask your coach for the remote DB Credentials and change those in `connection.php`.
        
This will connect you to a remote database your coach is hosting, from this point forward everything you enter in here, will be seen by everyone else in the group.
Now use your form on `insert.php` to push your details to the online database.
 
### Step 5:
We have managed to push our info to a local & remote database, now let's try and pull that same information out of there,<br/>
follow these instructions:

***Make sure you are using the local database again!***

- On `index.php`, list a table with summaries of most of the details of all people
- Make sure the table shows the following:
    - Their first name
    - Their last name
    - Their email
    - Their preferred language (in the form of an icon (flag))
    - A link to their personal page (`profile.php?user=$user_id`) (the link can also be, on their name or any other column you prefer)

### Step 6:
- On `profile.php` get the required user's details from the database
- Print them out on a profile page you design, if you need inspiration, you can look [here](https://www.google.com/search?q=profile+page+design&source=lnms&tbm=isch&sa=X&ved=0ahUKEwis5Juh07HkAhUIJFAKHeJKASYQ_AUIESgB&biw=2560&bih=1297#imgrc=jjirWCPSxqfBFM:)
- Include an API call to the following API: [Be Like Bill](https://github.com/gautamkrishnar/Be-Like-Bill), use the documentation to understand how you need to use it, do this using either `curl` in PHP or `ajax` in Javascript. The received image (from the api) needs to be worked into the profile page somewhere.(nice to have)
- Every column of the database table needs to be shown someway
- The final result needs to be a coherent profile page

### Step 7:
Next up we want to create some delete and edit functionality, sadly though we can't yet.
Imagine a webapp where you can edit other people's info, or delete their profile... That wouldn't be good... 
So let's make a login / registration system:

- Create a `login.php` file and fill it up with a login form (email/password or username/password)
- Rename `insert.php` to `register.php` and add a password & password confirmation field to the form
- Create an `auth.php` file and write both the login and registration logic in them
- The registration logic should:
    - Check if the email is valid (validate all other fields as well if necessary)
    - Check if password and password confirm are equal. Use `password_verify` for this.
    - Hash the password and add it to the database in it's hashed form (**NEVER** store unhashed / unencrypted passwords). Use `password_hash` for this.
    - If the registration fails, go back to the previous form, fill in all the previously filled in data (except the passwords) and show an error on the correct field
    - If the registration succeeds, go to `profile.php` and show the user's own profile.
- The login logic should:
    - Check if the filled in username / email can be found on a user with that credential
    - Check if the hashed database password, can be matched to the newly hashed (filled in) password
    - If not, go back to the login page, giving an error (**WATCH OUT:** never say whether the password or the username/email was incorrect, always say either one of them could be wrong) 
    - If it's correct, move to the `index.php` page
- Now, obviously we don't want non-logged-in people to see `index.php` with all our data, so protect `index.php` so that it checks for the user's login status and redirects to `login.php` when not logged in.

### Step 8:
So now that authentication is out of the way, we want to give the user's right to edit, though obviously we only want them to edit or remove their own profiles.

- On `profile.php` check if the logged in user's ID equals that of the one requested on the profile page, if so, show edit and delete buttons somewhere on the page.
- When those buttons are clicked, again your code should check whether this person has the rights to do the delete / edit action before executing it
- Obviously once executed, the edit action goes back to the profile, delete action, should go back to register page 

> This way, we eliminate any and all means of `hacking` our code

### Step 9: 
- Review for yourself, the different MySQLI / PDO functions you have learned
- Write down a small cheatsheet for yourself regarding the SQL functions 
- Congratulate yourself, you just taught yourself `MySQL` without any help, without any guidance... I'm impressed, honestly! :unicorn:

 

