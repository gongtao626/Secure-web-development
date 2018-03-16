<?php
include("session.php");
//destroy the sessions saved before.
session_destroy();
//automatically go back to homepage
header('Location: ./homepage.php');
?>
