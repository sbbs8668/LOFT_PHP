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
####### functions END


#### HW0 START
$hw = 0;
$ts = 0;
hw($hw, $ts);

CONST TEST_CONSTANTA = 'asd';
$user_name = "Igor";
function show_something(string $something = ''): string
{
    if ($something) {
        echo $something;
        br();
    }
    return 'SOMETHING';
}
$a = 1;
$b = '1';
if ($a == $b) {
    echo 'hi';
    br();
    show_something(TEST_CONSTANTA);
}
br();
#### HW0 END

#### HW1 START
$hw = 1;
$ts = 0;
hw($hw, $ts);

CONST ABC = 'абвгдеёжзийклмнопрстуфхцчшщыэюя';
CONST MY_NAME_IS = 'Меня зовут';
CONST I_AM_OLD_TEXT = [
    'part1' => 'Мне',
    1 => 'год',
    4 => 'года',
    5 => 'лет',
];
CONST SYMBOLS = [
    'DOT' => '.',
    'SEMICOLON' => ':',
    'DBLQUOTE_FORWARD' => '“',
    'DBLQUOTE_BACKWARD' => '”',
    'SNGLQUOTE' => '’',
    'EXLMMARK' => '!',
    'VERTBAR' => '|',
    'SLASH_FORW' => '/',
    'SLASH_BACKW' => '\\',
];

$getMyName = function(){
    $new_name = array_filter(
        array_map(
            function(string $thisLetter):string {
                if (rand(0, 1)) {
                    return $thisLetter;
                }
                return '';
            },
        mb_str_split(ABC)
        )
    );
    shuffle($new_name);
    $new_name[0] = mb_strtoupper($new_name[0]);
    $new_name = implode('', $new_name);
    return mb_substr( $new_name,0, rand(3, mb_strlen($new_name)));
};
$getMyAge = function(bool $underage = false, bool $restrictAge = false): string {
    if (!$underage) {
        $minAge = 18;
    } else {
        $minAge = 0;
    }
    if (!$restrictAge) {
        $maxAge = 80;
    } else {
        $maxAge = 120;
    }
    return (string)rand($minAge, $maxAge);
};
$getMyAgeText = function(string $age): string {
    $age = (int)substr($age, -1);
    if($age === 1) {
        return I_AM_OLD_TEXT[1];
    }
    if($age > 1 && $age < 5) {
        return I_AM_OLD_TEXT[4];
    }
    return I_AM_OLD_TEXT[5];
};

##1.1
$ts = 1;
hw($hw, $ts);

#How to concat a CONST with {} style?#
echo MY_NAME_IS . SYMBOLS['SEMICOLON'] . " {$getMyName()}" . SYMBOLS['DOT'];
br();
$todayIamThatOld = $getMyAge();
echo I_AM_OLD_TEXT['part1'] . " $todayIamThatOld {$getMyAgeText($todayIamThatOld)}" . SYMBOLS['DOT'];
br();
br();
$printSymbols = SYMBOLS;
unset($printSymbols['DOT']);
unset($printSymbols['SEMICOLON']);
echo implode(br(true), $printSymbols);
br();
br();

##1.2
$ts = 2;
hw($hw, $ts);

const ALL_PICTURES = 80;
const BY_FIXES = 23;
const BY_PENS = 40;
const THE_REST = ALL_PICTURES - BY_FIXES - BY_PENS;
pr(THE_REST);
br();
br();

##1.3
$ts = 3;
hw($hw, $ts);

const AGES = [
    'REGULAR_MIN_IMMATURE' => 1,
    'REGULAR_MIN_MATURE' => 18,
    'REGULAR_MAX' => 65,
];
const AGE_TEXTS = [
    'INSUFFICIENT_AGE' => 'Вам ещё рано работать',
    'STILL_HAS_TO_WORK' => 'Вам еще работать и работать',
    'TIME_TO_RETIRE' => 'Вам пора на пенсию',
    'OUTSIDE_AGE_RANGE' => 'Неизвестный возраст',

];
$age = $getMyAge(true, true);
if ($age >= AGES['REGULAR_MIN_MATURE'] && $age <= AGES['REGULAR_MAX']) {
    pr(AGE_TEXTS['STILL_HAS_TO_WORK']);
} elseif ($age > AGES['REGULAR_MAX']) {
    pr(AGE_TEXTS['TIME_TO_RETIRE']);
} elseif ($age >= AGES['REGULAR_MIN_IMMATURE'] && $age < AGES['REGULAR_MIN_MATURE']) {
    pr(AGE_TEXTS['INSUFFICIENT_AGE']);
} else {
    pr(AGE_TEXTS['OUTSIDE_AGE_RANGE']);
}
br();
br();

##1.4
$ts = 4;
hw($hw, $ts);

CONST COUNT_START = 0;
CONST COUNT_END = 10;
CONST WORKING_DAYS = [1, 2, 3, 4, 5];
CONST WEEK_END_DAYS = [6, 7];
CONST WORKING_TEXT = [
    'WORKING_DAYS' => 'Это рабочий день',
    'WEEKEND_DAYS' => 'Это выходной день',
    'UNKNOWN_DAYS' => 'Неизвестный день',
];
$day = rand(COUNT_START, COUNT_END);
switch (true) {
    case in_array($day,WORKING_DAYS) : {
        pr(WORKING_TEXT['WORKING_DAYS']);
        break;
    }
    case in_array($day,WEEK_END_DAYS) : {
        pr(WORKING_TEXT['WEEKEND_DAYS']);
        break;
    }
    default:
        pr(WORKING_TEXT['UNKNOWN_DAYS']);
        break;
}
br();
br();

##1.5
$ts = 5;
hw($hw, $ts);

$bmw = [
    'model' => 'X5',
    'speed' => '120',
    'doors' => '5',
    'year' => '2015',
];
$toyota = [
    'model' => '5X',
    'speed' => '210',
    'doors' => '7',
    'year' => '2017',
];
$opel = [
    'model' => '5',
    'speed' => '21',
    'doors' => '1',
    'year' => '2007',
];
$cars = [
    'bmw' => $bmw,
    'toyota' => $toyota,
    '$opel' => $opel,
];
CONST CAR_TEXT = 'CAR';
foreach ($cars as $brand => $car) {
    pr(CAR_TEXT." {$brand}");
    pr("{$car['model']} {$car['speed']} {$car['doors']} {$car['year']}");
    br();
}

##1.6
$ts = 6;
hw($hw, $ts);

const TABLE = 'table';
const TR = 'tr';
const TH = 'th';
const TD = 'td';
const STYLE = 'border: 1px solid gray; text-align: right';
function getStyle(int $color): string {

}
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
    if(!($x % 2) && !($y % 2)) {
        return [2, "($n)"];
    }
    if($x % 2 && $y % 2) {
        return [1, "[$n]"];
    }
    return [3, ''.$n];
}
pr(getTag(TABLE), true);
for($y = 0; $y < 10; $y++) {
    pr(getTag(TH, false, false), true);
    if ($y) {
        pr($y);
    }
    pr(getTag(TH, true, false), true);
}
for($y = 1; $y < 10; $y++) {
    pr(getTag(TR), true);
    for($x = 1; $x < 10; $x++) {
        if ($x === 1) {
            pr(getTag(TH, false, false), true);
            pr($y);
        }
        $printedNumber = getStringToPrint($x, $y, $x * $y);
        pr(getTag(TD, false, true, $printedNumber[0]), true);
        pr($printedNumber[1]);
        pr(getTag(TD, true), true);
        if ($x === 1) {
            pr(getTag(TH, true, false), true);
        }
    }
    pr(getTag(TR, true), true);
}
pr(getTag(TABLE, true), true);
/*Используя цикл for, выведите таблицу умножения размером 10x10. Таблица должна быть выведена с помощью HTML тега <table>.
Если значение индекса строки и столбца чётный, то результат вывести в круглых скобках.
Если значение индекса строки и столбца Нечётный, то результат вывести в квадратных скобках.
Во всех остальных случаях результат выводить просто числом.*/
##### HW1 END
