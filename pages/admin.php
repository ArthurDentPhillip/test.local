<?php include_once("classes.php");
session_start();
?>
<?php if (!isset($_POST["add_btn"])): ?>

    <form action="index.php?page=4" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id">
                <option value="0">Выберите категорию</option>
                <?php
                $pdo = Tools::connect();
                $list = $pdo->query('SELECT * FROM categories');
                while ($row = $list->fetch()) : ?>

                    <option value="<?php echo $row["id"] ?>">
                        <?php echo $row["category"] ?>
                    </option>

                <?php endwhile ?>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Название товара</label>
            <input type="text" name="name">
        </div>

        <div class="form-group">
            <label for="price">Цена товара</label>
            <input type="text" id="price" name="price">
        </div>

        <div class="form-group">
            <label for="sale_price">Цена товара со скидкой</label>
            <input type="text" id="sale_price" name="sale_price">
        </div>

        <div class="form-group">
            <label for="info">Описание товара</label>
            <textarea name="info" id="info"></textarea>
        </div>

        <div class="form-group">
            <label for="image_path">Изображение</label>
            <input type="file" id="image_path" name="image_path">
        </div>

        <button type="submit" class="btn btn-primary" name="add_btn">
            Создать
        </button>
    </form>

<?php else:

    if (is_uploaded_file($_FILES['image_path']["tmp_name"])) {
        $path = "images/" . $_FILES["image_path"]["name"];
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $path);
    }

    $category_id = $_POST["category_id"];
    $price = $_POST["price"];
    $sale_price = $_POST["sale_price"];
    $name = $_POST["name"];
    $info = $_POST["info"];

    $product = new Product($name, $category_id, $price, $sale_price, $info, 0, $path, 1);
    $product->intoDb();
endif; ?>

