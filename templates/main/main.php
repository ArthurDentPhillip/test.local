
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="/" method="POST">
<?php foreach ($user as $user): ?>
        <p>iD - <?= $user->getId() ?></p>
        <p>lOGIN - <?= $user->getLogin() ?></p>
        <p> PASSWORD - <?= $user->getPas() ?></p>
        <p> ROLE ID - <?= $user->getRoleId() ?></p>
        <p> dISCOUNT - <?= $user->getDiscount() ?></p>
        <p> TOTAL - <?= $user->getTotal() ?></p>
        <p> I MAGE - <?= $user->getImagePath() ?></p>
    <?php endforeach; ?>
        <button name="btn">BUTTON</button>
    </form>
</body>
</html>