###Requirements & Versions:  
    Symfony: 3.4.3  
    MySql Server: 5.7
    PHP: 7.2.19
    

###Run:  
1.  Create MySql user `root` with password `root`
2.  Open terminal then run command `cd <path/to/app/root>`
3.  Run `php bin/console doctrine:database:create` to create MySql DataBase
4.  Run `php bin/console server:start` to run symfony dev server
5.  Run `php bin/console doctrine:migrations:migrate`to migrate database
6.  Run `php bin/console doctrine:fixtures:load` to load fixture users