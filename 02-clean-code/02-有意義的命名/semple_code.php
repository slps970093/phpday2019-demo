<?php


// before 計算所有小考成績的平均分數

$arr = [
    10,
    75,
    95,
    78,
    75,
    72,
    98,
    0,
    52
];

$t = count($arr);

$tmp = 0;

foreach ($arr as $s) {
    $tmp += $s;
}

echo "avg:\t" . $tmp / $t;

// after 計算所有成績的平均分數


$scores = [
    10,
    75,
    95,
    78,
    75,
    72,
    98,
    0,
    52
];

$count = count($scores);

$total = 0;


foreach ($scores as $score) {
    $total += $score;
}

echo "avg:\t" . $total / $count;