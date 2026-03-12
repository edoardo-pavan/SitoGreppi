<?php
// admin/logout.php - Logout dalla dashboard
session_start();
session_destroy();
header('Location: login.php');
exit();
?>