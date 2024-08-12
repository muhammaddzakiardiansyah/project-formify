<?php
session_start();

session_destroy();
session_unset();

setcookie("key_1", "", time() - 3600, "/");
setcookie("key_2", "", time() - 3600, "/");

header("Location: /project-formify/");