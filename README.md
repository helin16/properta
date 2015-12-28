### Development Requrement
* [composser](https://getcomposer.org)
* [npm](https://www.npmjs.com)
* [bower](bower.io/)

### Get Started
#### Git
```Bash
git clone https://github.com/helin16/properta.git
```
#### PHP Packages
```Bash
cd properta
composer install
```
#### Front-end Packages
```Bash
cd public
bower install
```
#### Database
```Bash
mysql -e 'create database properta'
php artisan migrate:refresh --seed
```
#### Apache
```Apache
<Directory "S:\PhpstormProjects\properta\public">
Order Allow,Deny
Allow from all 
Require all granted
AllowOverride All
</Directory>

<VirtualHost *:8106>   
DocumentRoot "S:\PhpstormProjects\properta\public" 
</VirtualHost>
```
### Honorable Mentions
* [Entity Relationship Diagram](https://drive.google.com/file/d/0Bxgq42UyfKTIV2FSb09KU3Vycms/view?usp=sharing)
* [Laravel](laravel.com)
* [Bootstrap](laravel.com)
* [jQuery](https://jquery.com)
* [Mustache](https://mustache.github.io)
