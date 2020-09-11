# SnowTricks Project 6 - First community site done with Symfony 5.1 [![Codacy Badge](https://api.codacy.com/project/badge/Grade/051eb0bc18694f6a85c99623b8aa5d9a)](https://app.codacy.com/manual/nayodahl/snowtricks?utm_source=github.com&utm_medium=referral&utm_content=nayodahl/snowtricks&utm_campaign=Badge_Grade_Dashboard)

Community snowboard site project done for OPENCLASSROOMS, made with Symfony 5.1

## What is this Project ?

This site is made of PHP, using Symfony 5.1.
All external libraries and bundles are forbidden, except those maintained by Symfony core team (https://flex.symfony.com/).
This means no liip/LiipImagineBundle, no StofDoctrineExtensionsBundle etc...

Here are the rules that needed to be followed : 

* The site has pages for visitors, and visitors can signin in to become members.
* Commenting a trick is only for members logged in.
* Tricks can be created, edited and deleted by any member (it's a community site).
* Tricks can have images, youtube videos, and an image can be selected has a featured image.
* All wireframes are given and the design must stick to them.
* Initial dataset is added with 10 Tricks and one activated user.

This site is online here : https://snowtricks.nayo.cloud and can be tested


## Getting started

- Clone Repository on your web server
- Install backend dependancies using Composer with dev depandancies (composer install, https://getcomposer.org/doc/01-basic-usage.md). You may need to remove composer.lock file
- Create a database on your SQL server
- Configure access to this database on .env file at source of the project (user, password, name of db, address etc..)
- Run doctrines migrations (php bin/console doctrine:migration:migrate). You can check your migration status with php bin/console doctrine:migration:status
- Load initial dataset using Datafixtures (php bin/console doctrine:fixtures:load)
- Configure your mail setup on your web server editing .env file, as this site sends mails for registration. I used a https://mailtrap.io/ inbox during the development - 
- Install frontend dependancies using Yarn (yarn install).
- Generates front assets using yarn (yarn run encore production).
- Now that you are done, you can switch to production environnement editing .env file (change line with APP_ENV=prod)
- Remove backend dev dependancies using Composer (composer install --no-dev --optimize-autoloader)
- Clear your symfony cache (php bin/console cache:clear)

## Let's go

- Username from datafixtures : jimmy
- Password is @dmIn123

## Author

**Anthony Fachaux** - Openclassrooms Student - Dev PHP/Symfony