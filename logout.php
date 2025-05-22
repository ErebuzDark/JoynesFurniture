<?php

unset($userID);
session_destroy();
header("Location: index.php");
exit();
?>