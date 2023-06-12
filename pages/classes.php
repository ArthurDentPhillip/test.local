<?php

class Tools
{
        public static $user_name = 'Hello world';
        static function connect(
        $host = "localhost",
        $user = "root",
        $pass = "",
        $db = "shop"
    ) {
        $con = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8';
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
        ];

        try {
            $pdo = new PDO($con, $user, $pass, $opt);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function register($login, $pass, $image_path = null)
    {
        $login = trim(htmlspecialchars($login));
        $pass = trim(htmlspecialchars($pass));

        // Проверка на пустые поля
        if ($login == "" || $pass == "") {
            echo '<h4 class="text-danger">Все поля обязательны!</h4>';
            return false;
        }

        // Проверка на длину слов
        if (strlen($login) < 3 || strlen($login) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
            echo '<h4 class="text-danger">Количество символов должно быть от 3 до 30!</h4>';
            return false;
        }

        $user = new User($login, $pass, $image_path);
        $err = $user->intoDb();
        
        if ($err) {
            echo '<h4 class="text-danger">Ошибка: ' . $err . '</h4>';
            return false;
        }

        return true;
    }
    static function entry($login, $pass){
        // Проверка на пустые поля
        if ($login == "" || $pass == "") {
            echo '<h4 class="text-danger">Все поля обязательны!</h4>';
            return false;
        }

        // Проверка на длину слов
        if (strlen($login) < 3 || strlen($login) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
            echo '<h4 class="text-danger">Количество символов должно быть от 3 до 30!</h4>';
            return false;
        }
        
            $pdo = self::connect();
            $ps = $pdo->query("SELECT * FROM `users` WHERE login = '$login' AND pass = '$pass';");
            $row = $ps->fetch();
            $ps2 = $pdo->query("SELECT image_path FROM `users` WHERE login = '$login' AND pass = '$pass';");
            $row2 = $ps2->fetch();
            self::$user_name = $login;
            var_dump($login);

            if(isset($row['login'])){
                session_start();
                $_SESSION['login'] = "true";
                // return true;
                if($row['role_id']=== "2"){
                    $_SESSION['user'] = "true";
                    // header("Location: /index.php?page=1");
                }
                else{
                    $_SESSION['admin'] = "true";
                    // header("Location: /index.php?page=1");
                }
            }
            // else{
            //     echo 'no';
            // }
            // var_dump(isset($row['login']));
            // return false;

}
}

class User
{
    protected $id;
    protected $login;
    protected $pass;
    protected $role_id;
    protected $discount;
    protected $total;
    protected $image_path;

    function __construct($login, $pass, $image_path, $id = 0)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->image_path = $image_path;
        $this->total = 0;
        $this->discount = 0;
        $this->role_id = 2;
        $this->id = $id;
    }


    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare(
                'INSERT INTO users(login, pass, role_id, discount, total, image_path) 
                VALUES(:login, :pass, :role_id, :discount, :total, :image_path)'
            );

            $ar = [
                "login" => $this->login,
                "pass" => $this->pass,
                "image_path" => $this->image_path,
                "total" => $this->total,
                "discount" => $this->discount,
                "role_id" => $this->role_id
            ];

            $ps->execute($ar);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    static function fromDb($id)
    {
        $user = null;
        try {

            $pdo = Tools::connect();
            $ps = $pdo->prepare('SELECT * FROM users WHERE id=?');
            $ps->execute($id);
            $row = $ps->fetch();

            $user = new User($row["login"], $row["pass"], $row["id"]);
            return $user;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}


class Product
{
    public $id, $name, $category_id, $price, $sale_price, $info, $rate, $image_path, $qty;

    function __construct($name, $category_id, $price, $sale_price, $info, $rate, $image_path, $qty, $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->sale_price = $sale_price;
        $this->info = $info;
        $this->rate = $rate;
        $this->image_path = $image_path;
        $this->qty = $qty;
    }

    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare(
                'INSERT INTO products(name, category_id, price, sale_price, info, rate, image_path, qty) 
                VALUES(:name, :category_id, :price, :sale_price, :info, :rate, :image_path, :qty)'
            );

            $ar = [
                "name" => $this->name,
                "category_id" => $this->category_id,
                "price" => $this->price,
                "sale_price" => $this->sale_price,
                "info" => $this->info,
                "rate" => $this->rate,
                "image_path" => $this->image_path,
                "qty" => $this->qty,
            ];
            $ps->execute($ar);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    static function fromDb($id)
    {
        $product = null;

        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare('SELECT * FROM products WHERE id=?');

            $ps->execute([$id]);
            $row = $ps->fetch();
            $product = new Product(
                $row["name"],
                $row["category_id"],
                $row["price"],
                $row["sale_price"],
                $row["info"],
                $row["rate"],
                $row["image_path"],
                $row["qty"],
                $row["id"]
            );
            return $product;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function getProducts($categoryId = 0)
    {
        $ps = null;
        $products = null;

        try {
            $pdo = Tools::connect();

            if ($categoryId == 0) {
                $ps = $pdo->prepare('SELECT * FROM products');
                $ps->execute();
            } else {
                $ps = $pdo->prepare('SELECT * FROM products WHERE category_id=?');
                $ps->execute([$categoryId]);
            }
            
            while ($row = $ps->fetch()) {
                $product = new Product(
                    $row["name"],
                    $row["category_id"],
                    $row["price"],
                    $row["sale_price"],
                    $row["info"],
                    $row["rate"],
                    $row["image_path"],
                    $row["qty"],
                    $row["id"]
                );

                $products[] = $product;
            }

            return $products;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function draw()
    {
        echo '<div class="col-md-3 col-12 mx-1 my-1" style="background-color:#fafafa;">';
        echo '<a href="pages/product-info.php?name=' . $this->id . '">';
        echo $this->name;
        echo '</a>';
        echo '<div>' . $this->rate . '</div>';
        echo '<div><img src="' . $this->image_path . '"></div>';
        echo '<div>';
        echo '<p class="text-success">' . $this->price . '</p>';
        echo '<p class="text-danger">' . $this->sale_price . '</p>';
        echo '</div>';
        echo "<div>$this->info</div>";

        $user = "";
        if (!isset($_SESSION["reg"]) || $_SESSION["reg"] == "") {
            $user = "cart_" . $this->id;
        } else {
            $user = $_SESSION["reg"] . "_" . $this->id;
        }

        echo "<button class='btn btn-success col-xs-offset-1 col-xs-10' onclick=createCookie('" . $user . "','" . $this->id . "')>Add To My Cart</button>";
        echo '</div>';
    }

    function drawCart()
    {
        echo "<div class='d-flex' style='margin:2px;'>";
        echo "<img src='" . $this->image_path . "' width='70px' class='col-sm-12 col-md-4 col-lg-3'/>";
        echo "<span style='margin-right:10px;background-color:#ddeeaa;color:blue;font-size:16pt' class='col-sm-3 col-md-3 col-lg-3'>";
        echo $this->name;
        echo "</span>";
        echo "<span style='margin-left:10px;color:red;font-size:16pt;background-color:#ddeeaa;' class='col-sm-2 col-md-2 col-lg-2' >";
        echo "$&nbsp;" . $this->price;
        echo "</span>";

        $ruser = '';
        if (!isset($_SESSION['reg']) || $_SESSION['reg']  == "") {
            $ruser = "cart_" . $this->id;
        } else {
            $ruser = $_SESSION['reg'] . "_" . $this->id;
        }

        echo "<button type='button' class='btn btn-sm btn-danger' style='margin-left:10px;' onclick=eraseCookie('" . $ruser . "')>x</button>";
        echo "</div>";
    }
}
