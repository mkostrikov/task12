<?php
include_once __DIR__ . '/func.php';
include_once __DIR__ . '/example_persons_array.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Идеальный подбор пары</title>
</head>

<body>
    <header class="header">
        <h1>Идеальный подбор пары</h1>
    </header>
    <main class="main">
        <section class="menu">
            <form action="/admin.php" method="post" class="form-admin">
                <button type="submit" class="btn-admin">Администрирование</button>
            </form>
        </section>
        <section class="content">
            <form method="post" class="form">
                <label>
                    Фамилия <input type="text" name="surname" id="surname" placeholder="Иванов">
                </label>
                <label>
                    Имя <input type="text" name="name" id="name" placeholder="Иван">
                </label>
                <label>
                    Отчество <input type="text" name="patronymic" id="patronymic" placeholder="Иванович">
                </label>
                <button type="submit">Найти пару</button>
            </form>

            <div class="answer-form">
                <?php
                $filter = [
                    'surname' => array(
                        'filter' => FILTER_VALIDATE_REGEXP,
                        'options' => array('regexp' => '/[а-я]+/iu')
                    ),
                    'name' => array(
                        'filter' => FILTER_VALIDATE_REGEXP,
                        'options' => array('regexp' => '/[а-я]+/iu')
                    ),
                    'patronymic' => array(
                        'filter' => FILTER_VALIDATE_REGEXP,
                        'options' => array('regexp' => '/[а-я]+/iu')
                    )
                ];
                $postFilter = filter_input_array(INPUT_POST, $filter);
                $postFilterValues = array_values($postFilter);
                $result = in_array(false, $postFilterValues, true);
                if (!$result) {
                    getPerfectPartner($_POST['surname'], $_POST['name'], $_POST['patronymic'], $example_persons_array);
                } else {
                    echo '<div class="error">Не все поля заполнены правильно.</div>';
                }
                ?>
            </div>
        </section>
    </main>
    <footer></footer>


</body>

</html>