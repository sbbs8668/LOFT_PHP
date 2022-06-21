<?php
####### functions START
function hw(int $hw, int $ts): void
{
    $ts = $ts ? " task:$ts" : '';
    echo "HW$hw$ts";
    echo '<br/><br/>';
}
function getTextString(int $stringMaxLength = 0): string
{
    $strinMinLength = 3;
    $abc = 'абвгдеёжзийклмнопрстуфхцчшщыэюя';
    $new_name = array_filter(
        array_map(
            function(string $thisLetter):string {
                if (rand(0, 1)) {
                    return $thisLetter;
                }
                return '';
            },
            mb_str_split($abc)
        )
    );
    shuffle($new_name);
    $new_name[0] = mb_strtoupper($new_name[0]);
    $new_name = implode('', $new_name);
    return mb_substr( $new_name,0, rand($strinMinLength, $stringMaxLength ?? mb_strlen($new_name)));
};
function createNewFile(string $fileName, string $fileContent, string $path = './'): string
{
    $newFile = fopen($path . $fileName, 'w');
    fwrite($newFile, $fileContent);
    fclose($newFile);

    return $path . $fileName;
}
#######HW functions START
function task3_1(): void
{
    $users = [];
    $i = 1;
    $numberOfUsers = 50;
    $userMinAge = 18;
    $userMaxAge = 45;
    while ($i <= $numberOfUsers) {
        $users[$i] = [];
        $users[$i]['id'] = $i;
        $users[$i]['name'] = getTextString(5);
        $users[$i]['age'] = rand($userMinAge, $userMaxAge);
        $i++;
    }
    $jsonFileName = 'users.json';
    $jsonFileContent = json_encode($users);

    $usersJsonFile = createNewFile($jsonFileName, $jsonFileContent);

    $usersFromJson = json_decode(file_get_contents($usersJsonFile), true);
    unlink($usersJsonFile);

    $usersFiledToCount = 'name';
    $uniqueUsersNameCount = array_count_values(
        array_column($usersFromJson, $usersFiledToCount)
    );

    foreach ($uniqueUsersNameCount as $userName => $userNameCount) {
        echo "$userName: $userNameCount";
        echo '<br/>';
    }
    echo '<br/>';

    $usersFiledToCount = 'age';
    $usersAverageAgeText = 'User average age is:';
    $usersAgesArray = array_map(function($user) use ($usersFiledToCount) {
        return $user[$usersFiledToCount];
    }, $usersFromJson);
    $usersAverageAge = array_sum($usersAgesArray) / count($usersAgesArray);
    echo "$usersAverageAgeText $usersAverageAge";

}

function task3_2(): void
{
    $burgersProjectName = 'Burgers';
    echo '<a href="burgers/index.html" target="_blank">' . $burgersProjectName . '</a>';
}

function task4_1()
{
    require('src/classes/Rates.php');

    $student = Rates\Student::initialize();
    /*time - minutes, distance - km*/
    $student->calculatePrice(120, 12);
    $student->addGps();
    echo $student->getReceipt();
    echo '<br/>';
    echo '<br/>';

    $basic = Rates\Basic::initialize();
    /*time - minutes, distance - km*/
    $basic->calculatePrice(60, 5);
    $basic->addGps();
    echo $basic->getReceipt();
    echo '<br/>';
    echo '<br/>';

    $hours = Rates\Hours::initialize();
    /*time - minutes*/
    $hours->calculatePrice(150);
    $hours->addDriver();
    $hours->addGps();
    echo $hours->getReceipt();
    echo '<br/>';
    echo '<br/>';
}
