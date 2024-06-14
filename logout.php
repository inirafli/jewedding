<?php
session_start();
session_destroy();
header('Location: /jewedding/home.php');
exit();
