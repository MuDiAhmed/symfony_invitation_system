### Requirements & Versions:  
    Symfony: 3.4.3  
    MySql Server: 5.7
    PHP: 7.2.19
    Composer: 1.9.0
    

### Run:  
1.  Create MySql user `root` with password `root`
2.  Open terminal then run command `cd <path/to/app/root>`
3.  Run `Composer install` to install required packages
4.  Run `php bin/console doctrine:database:create` to create MySql DataBase
5.  Run `php bin/console server:start` to run symfony dev server
6.  Run `php bin/console doctrine:migrations:migrate`to migrate database
7.  Run `php bin/console doctrine:fixtures:load` to load fixture users
8.  Run `mkdir -p config/jwt`
9.  Run `openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096` then use the `JWT_PASSPHRASE` in the `.env` file as the passphrase
10.  Run `openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`
