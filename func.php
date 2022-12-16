<?php

function getFullnameFromParts(string $surname, string $name, string $patronymic)
{
    return "$surname $name $patronymic";
}

function getPartsFromFullname(string $fullname)
{
    $keys = ['surname', 'name', 'patronymic'];
    return array_combine($keys, explode(' ', $fullname));
}

function getShortName(string $fullname)
{
    $partsName = getPartsFromFullname($fullname);
    $shortSurName = mb_substr($partsName['surname'], 0, 1);
    return "{$partsName['name']} {$shortSurName}.";
}

function getGenderFromName(string $fullname)
{
    $partsName = getPartsFromFullname($fullname);
    $gender = 0;
    $patronymic = $partsName['patronymic'];
    $name = $partsName['name'];
    $surname = $partsName['surname'];
    if (mb_substr($patronymic, (mb_strlen($patronymic) - 3), 3) === 'вна') {
        $gender -= 1;
    }
    if (mb_substr($patronymic, (mb_strlen($patronymic) - 2), 2) === 'ич') {
        $gender += 1;
    }
    if (mb_substr($name, (mb_strlen($name) - 1), 1) === 'а') {
        $gender -= 1;
    }
    if (mb_substr($name, (mb_strlen($name) - 1), 1) === 'й') {
        $gender += 1;
    }
    if (mb_substr($name, (mb_strlen($name) - 1), 1) === 'н') {
        $gender += 1;
    }
    if (mb_substr($surname, (mb_strlen($surname) - 2), 2) === 'ва') {
        $gender -= 1;
    }
    if (mb_substr($surname, (mb_strlen($surname) - 1), 1) === 'в') {
        $gender += 1;
    }

    return $gender <=> 0;
}

function getGenderDescription(array $array)
{
    $males = [];
    $females = [];
    $undefined = [];
    foreach ($array as $person) {
        switch (getGenderFromName($person['fullname'])) {
            case 1:
                $males[] = $person;
                break;
            case 0:
                $undefined[] = $person;
                break;
            case -1:
                $females[] = $person;
                break;
        }
    }

    function percent(int $amount, int $total)
    {
        $num = round($amount / $total * 100, 1);
        return number_format($num, 1, '.', '');
    }

    $percentMales = percent(count($males), count($array));
    $percentUndefined = percent(count($undefined), count($array));
    $percentFemales = percent(count($females), count($array));

    echo '<table><tbody>';
    echo '<tr><td>Гендерный состав аудитории:</td></tr>';
    echo '<tr><td>------------------------------------------------</td></tr>';
    echo "<tr><td>Мужчины - {$percentMales}%</td></tr>";
    echo "<tr><td>Женщины - {$percentFemales}%</td></tr>";
    echo "<tr><td>Не удалось определить - {$percentUndefined}%</td></tr>";
    echo '</tbody></table>';
}

function getPerfectPartner(string $surname, string $name, string $patronymic, array $array)
{
    $fullname = mb_convert_case(getFullnameFromParts($surname, $name, $patronymic), MB_CASE_TITLE);
    $gender = getGenderFromName($fullname);
    if ($gender !== 0) {
        do {
            $partner = $array[rand(0, count($array) - 1)];
            $partnerGender = getGenderFromName($partner['fullname']);
        } while ($gender === $partnerGender || $partnerGender === 0);
        $percentCompatibility = function () {
            $num = rand(50, 99) + rand(0, 100) / 100;
            return number_format($num, 2, '.', '');
        };
        $shortName = getShortName($fullname);
        $shortNamePartner = getShortName($partner['fullname']);
        $message = <<<message
        $shortName + $shortNamePartner <br>
        = <br>
        ♡ Идеально на {$percentCompatibility()}% ♡
        message;
        echo "$message";
    } else {
        echo 'Нет подходящей пары.';
    }
}
