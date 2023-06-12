<?php 
// echo '<pre>';
// print_r($_SESSION['login']);
// echo '</pre>';
include_once("classes.php");
session_start();
?>
<form action="index.php?page=1" method="POST">
    <select name="category_id" id="category_id" onchange="getItemsByCategory(this.value)">

        <option value="0">Выберите категорию</option>
        <?php
        $pdo = Tools::connect();
        $ps = $pdo->prepare('SELECT * FROM categories');
        $ps->execute();
        while ($row = $ps->fetch()) : ?>

            <option value="<?php echo $row["id"] ?>"><?php echo $row["category"] ?></option>

        <?php endwhile ?>

    </select>
</form>
<div id="res">
    <?php
    $catId = 0;
    if (isset($_POST["category_id"])) {
        $catId = $_POST["category_id"];
    }
    $products = Product::getProducts($catId);

    echo '<div class="row">';
    foreach ($products as $product) {
        $product->draw();
    }
    echo '</div>';
    ?>
</div>

<script>
    function getItemsByCategory(cat) {
        let res = document.getElementById("res");

        if (cat == "") {
            res.innerHTML = "";
        }

        let ao = null;
        if (window.XMLHttpRequest) {
            ao = new XMLHttpRequest();
        } else {
            ao = new ActiveXObject("Microsoft.XMLHTTP");
        }

        ao.onreadystatechange = function() {
            if (ao.readyState == 4 && ao.status == 200) {
                res.innerHTML = ao.responseText;
            }
        }

        ao.open("POST", "pages/list.php", true);
        ao.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ao.send("cat=" + cat);
    }

    function createCookie(user_name, id) {
        
        let date = new Date(Date.now() + 1000 * 60 * 30);
        document.cookie = user_name + '=' + id + ';path=/;expires=' + date.toUTCString;

        console.log(user_name);
    }
</script>