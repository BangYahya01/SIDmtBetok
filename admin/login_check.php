<?php
session_start();
if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}
