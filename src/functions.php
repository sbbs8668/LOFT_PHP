<?php


####### functions START
function br(bool $return = false) {
    if ($return) {
        return '<br>';
    }
    echo '<br/>';
}
function pr(mixed $anything, bool $html = false): void
{
    if (!$html) {
        $anything = print_r($anything, 1);
        echo "<xmp>$anything</xmp>";
    } else {
        echo $anything;
    }
}
function hw(int $hw, int $ts): void
{
    $ts = $ts ? " task:$ts" : '';
    pr("HW$hw$ts");
}
/*mtpl tbl start*/
const TABLE = 'table';
const TR = 'tr';
const TH = 'th';
const TD = 'td';
const STYLE = 'border: 1px solid gray; text-align: right';
function getTag(string $tag, bool $close = false, $style = true, int $color = 0): string
{
    if ($color === 0) {
        $color = '';
    }
    if ($color === 1) {
        $color = '; background-color: lightgreen';
    }
    if ($color === 2) {
        $color = '; color: white; background-color: deeppink';
    }
    if ($color === 3) {
        $color = '; background-color: lightgray';
    }
    if ($color === 4) {
        $color = '; background-color: black';
    }
    if ($style) {
        $style = ' style ="' . STYLE . "$color\"";
    } else {
        $style = '';
    }
    if ($close) {
        return "</$tag>";
    }
    return "<$tag" . $style . ">";
}
function getStringToPrint(int $x, int $y, int $n): array {
    if ($n === 0) {
        return [4, ""];
    }
    if(!($x % 2) && !($y % 2)) {
        return [2, "($n)"];
    }
    if($x % 2 && $y % 2) {
        return [1, "[$n]"];
    }
    return [3, ''.$n];
}
function multiplyTable(int $from = 1, int $to = 9): void
{
    /*$from = abs($from);
    $to = abs($to);*/
    if ($from > $to) {
        [$from, $to] = [$to, $from];
    }
    $to += 1;

    pr(getTag(TABLE), true);
    for($y = $from - 1; $y < $to; $y++) {
        pr(getTag(TH, false, false), true);
        if ($y >= $from) {
            if ($y === 0) {
                $y = '';
            }
            pr($y);
            if ($y === '') {
                $y = 0;
            }
        }
        pr(getTag(TH, true, false), true);
    }
    for($y = $from; $y < $to; $y++) {
        pr(getTag(TR), true);
        for($x = $from; $x < $to; $x++) {
            if ($x === $from) {
                pr(getTag(TH, false, false), true);
                if ($y === 0) {
                    $y = '';
                }
                pr($y);
                if ($y === '') {
                    $y = 0;
                }
            }
            $printedNumber = getStringToPrint($x, $y, $x * $y);
            pr(getTag(TD, false, true, $printedNumber[0]), true);
            pr($printedNumber[1]);
            pr(getTag(TD, true), true);
            if ($x === $from) {
                pr(getTag(TH, true, false), true);
            }
        }
        pr(getTag(TR, true), true);
    }
    pr(getTag(TABLE, true), true);
}
/*mtpl tbl end*/
####### functions END

function task1(array $strings, $return = false)
{
    foreach ($strings as $index => $string) {
        $strings[$index] = "<p>$string</p>";
    }
    if ($return) {
        return implode('', $strings);
    }
    pr(print_r($strings, true));
}

function task2(...$array)
{
    if (!in_array($array[0], ['+', '-', '/', '*']) || count($array) < 3) {
        return;
    }
    $msign = array_shift($array);
    pr(implode(" $msign ", $array));
}

function task3()
{
    multiplyTable(0, 9);
    multiplyTable(0, 5);
    multiplyTable(1, 10);
    multiplyTable(3, 21);

    multiplyTable(5, 1);
    multiplyTable(-11, 0);
    multiplyTable(-1, -12);

    multiplyTable(3, -18);
}

function task4()
{
    pr(date('d.m.Y H:i'));
    pr(strtotime('24.02.2016 00:00:00'));
}

function task5()
{
    $str = 'Карл у Клары украл Кораллы';
    pr(implode('', explode('К', $str)));
    pr(str_replace('Две', 'Три', 'Две бутылки лимонада'));
}

function task6()
{
    $fileName = 'test.txt';
    $newFile = fopen($fileName, 'w');
    $text = 'Hello again!';
    fwrite($newFile, $text);
    fclose($newFile);
    pr(file_get_contents($fileName));
    unlink($fileName);
    /*Создайте файл test.txt средствами PHP. Поместите в него текст - “Hello again!”
Напишите функцию, которая будет принимать имя файла, открывать файл и выводить содержимое на экран.*/
}

function task7()
{

}

function task8()
{

}

function task9()
{

}

function task10()
{

}
