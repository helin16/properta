<html>
<body onload="loadUser">

<form action="/user/login">
    User name:<br>
    <input type="text" name="username" value="">
    <br>
    Password:<br>
    <input type="password" name="pwd" value="">
    <br><br>
    <input type="submit" value="Submit">
</form>


</body>
</html>

<?php

echo trans('user::example.welcome');