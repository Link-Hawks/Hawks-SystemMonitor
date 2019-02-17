<?php
$senha = md5($_SERVER['PHP_AUTH_PW']);
if (!(isset($_SERVER['PHP_AUTH_USER']) && strtolower($_SERVER['PHP_AUTH_USER']) =="hawks" && $senha == "202cb962ac59075b964b07152d234b70")) {
    header('WWW-Authenticate: Basic realm="Autenticação no sistema"');
    header('HTTP/1.0 401 Unauthorized');
    header("Content-type: text/html; charset=utf-8");
    echo "<img src='./img/dog401.jpg'>";
    exit;
}
