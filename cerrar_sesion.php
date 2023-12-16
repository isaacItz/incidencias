<?php
session_start();
session_destroy();

// Redirigir al formulario de inicio de sesión
header("Location: login.html");
exit();
?>