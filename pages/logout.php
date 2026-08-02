<?php
include '../php/authGuard.php';
session_destroy();
header("Location:landing.php");
