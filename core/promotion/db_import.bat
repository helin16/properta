@echo off
:: Remove Existing databases
c:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe -u root -proot -e "DROP DATABASE IF EXISTS properta"
Pause

:: Create new databases
c:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe -u root -proot -e "CREATE DATABASE `properta` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci"
Pause

:: Import sql file
c:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe -u root -proot properta < .\structure.sql
Pause
c:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe -u root -proot properta < .\data.sql
Pause
