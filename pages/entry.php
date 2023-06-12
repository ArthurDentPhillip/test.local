<?php 
// setcookie('ggg', 'gggg', 0, '/');
// if($tmp === 'true'){
//     setcookie('GG', 'GG', 0, '/');
    // session_start();
    // $_SESSION['login'] = "true";
    // echo $_SESSION['login'];
// }
// $tmp = Tools::entry($_POST["login"], $_POST["pass"]);
// echo $tmp;
// if($tmp === true){
//     unset($_COOKIE['gggg']); 
//     setcookie('ggg', null, -1, '/'); 
    
// }
session_start();

?>
<?php if (!isset($_POST["reg_btn"]) ):?>
    <h2 class="my-3">Вход</h2>
    <form action="index.php?page=5" method="POST">
        <div class="form-group mb-3">
            <label for="login">Логин</label>
            <input type="text" class="form-control" name="login">
        </div>
        <div class="form-group mb-3">
            <label for="pass">Пароль</label>
            <input type="password" class="form-control" name="pass">
        </div>
        <button type="submit" name="reg_btn" class="btn btn-success">Войти</button>
    </form>
<?php else:
Tools::entry($_POST["login"], $_POST["pass"]);
endif; ?>