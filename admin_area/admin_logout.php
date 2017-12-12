<?php

session_start();
session_destroy();
echo "<script>window.open('admin_login.php?not_admin=YOU ARE LOGGED OUT!','_self')</script>";
