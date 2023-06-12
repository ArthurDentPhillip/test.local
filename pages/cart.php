<form action="index.php?page=2" method="POST">
    <?php
    include_once("classes.php");
    session_start();
    $ruser = '';
    if (!isset($_SESSION['reg']) || $_SESSION['reg']  == "") {
        $ruser = "cart";
    } else {
        $ruser = $_SESSION['reg'];
    }
    $total = 0;

    foreach ($_COOKIE as $key => $value) :

        $pos = strpos($key, "_");

        if (substr($key, 0, $pos) == $ruser) {
            $id = substr($key, $pos + 1);
            $prod = Product::fromDb($id);
            $total += $prod->price;
            $prod->drawCart();
        }

    ?>

    <?php endforeach ?>


    <hr>

    <div class="d-flex justify-content-between">
        <div>
            <?php echo "Полная стоимость: " . $total ?>
        </div>

        <?php
        echo "<button type='button' class='btn btn-sm btn-danger' style='margin-left:10px;' onclick='allEraseCookie()'>x</button>";
        ?>

    </div>
</form>


<script>
    function eraseCookie(name) {
        let theCookies = document.cookie.split(";");

        for (let i = 1; i <= theCookies.length; i++) {
            let str = theCookies[i-1];
            let res = '';

            if(str[0]!=='c'){
                res = str.substring(1,7);
            }
            else{
                res = str.substring(0,6);
            }

            if (res === String(name)) {
                console.log('yes');
                let theCookie = theCookies[i-1].split('=');
                var date = new Date(new Date().getTime() - 360000);
                document.cookie = theCookie[0] + "=" +theCookie[1] + "; path=/; expires = " + date.toUTCString();
                location.reload();
            }
        }
    }
    function allEraseCookie() {
        let theCookies = document.cookie.split(";");
        for (let i = 1; i <= theCookies.length; i++) {
                let theCookie = theCookies[i-1].split('=');
                var date = new Date(new Date().getTime() - 360000);
                document.cookie = theCookie[0] + "=" +theCookie[1] + "; path=/; expires = " + date.toUTCString();
                location.reload();
        }
    }
</script>