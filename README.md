### Requrement
* [Composser](https://getcomposer.org)
* [npm](https://www.npmjs.com)
* [bower](bower.io/)

### Get Started
#### Git
```
git clone https://github.com/helin16/properta.git
```
#### PHP packages
```
cd properta
compossor install
```
#### Front-end Packages
```
cd public
bower install
```
#### Database
```
mysql -e 'create database properta'
php artisan migrate:refresh --seed
```
#### web hosting
```
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

