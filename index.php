<?php
#### HW0 START
CONST TEST_CONSTANTA = 'asd';
$user_name = "Igor";

function show_something(string $something = ''): string
{
    if ($something) {
        echo $something;
    }
    return 'SOMETHING';
}

$a = 1;
$b = '1';

if ($a == $b) {
    echo 'hi';
    show_something(TEST_CONSTANTA);
}
#### HW0 END

