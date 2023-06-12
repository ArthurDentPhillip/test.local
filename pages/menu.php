<?php 
include_once("classes.php");
session_start();
var_dump(Tools::$user_name);
?>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
        <?php if(!empty($_SESSION['login'])):?>
        <a class="nav-link" href="/index.php?page=1">Каталог</a>
        <a class="nav-link" href="/index.php?page=2">Корзина</a>
        <?endif; ?>
        <?php if(empty($_SESSION['login'])):?>
        <a class="nav-link" href="/index.php?page=3">Регистрация</a>
        <?endif; ?>
        <?php if(!empty($_SESSION['admin'])):?>
        <a class="nav-link" href="/index.php?page=4">Админ</a>
        <?endif; ?>
      
        <a class="nav-link" href="/index.php?page=5">Войти</a>

     
    </div>
</div>