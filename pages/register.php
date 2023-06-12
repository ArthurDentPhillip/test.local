<h2 class="my-3">Регистрация</h2>


<?php if ( ! isset($_POST["reg_btn"]) ) : ?>
    <form action="index.php?page=3" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="login">Логин</label>
            <input type="text" class="form-control" name="login">
        </div>
        <div class="form-group mb-3">
            <label for="pass">Пароль</label>
            <input type="password" class="form-control" name="pass">
        </div>
        <div class="form-group mb-3">
            <label for="pass2">Повторите пароль</label>
            <input type="password" class="form-control" name="pass2">
        </div>
        <div class="form-group mb-3">
            <label for="pass2">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group mb-3">
            <label for="image_path">Email</label>
            <input type="file" class="form-control" name="image_path">
        </div>
        <button type="submit" name="reg_btn" class="btn btn-success">Регистрация</button>
    </form>
<?php else :

    // Запись файла
    if (is_uploaded_file($_FILES['image_path']["tmp_name"])) {
        $path = 'images/' . $_FILES["image_path"]["name"];
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $path);
    }

    // Регистрация пользователя
    if (Tools::register($_POST["login"], $_POST["pass"],  $_FILES["image_path"]["name"])) {
        echo '<h3 class="text-success">Новый пользователь зарегистрирован!</h3>';
    }


endif ?>