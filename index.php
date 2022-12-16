<?php
include_once __DIR__ . '/func.php';
include_once __DIR__ . '/example_persons_array.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= getPerfectPartner('Петров', 'Петр', 'ПЕТРОвич', $example_persons_array);
    ?>
</body>
</html>

