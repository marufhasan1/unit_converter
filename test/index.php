<?php
require __DIR__ . "/UnitConverter.php";

const rel = [
    [
        "caption" => "Bag",
        "value" => 1
    ],
    [
        "caption" => "Cartoon",
        "value" => 2
    ],
    [
        "caption" => "KG",
        "value" => 25
    ],
];
// const rel = [
//     [
//         "caption" => "Cartoon",
//         "value" => 1
//     ],
//     [
//         "caption" => "Box",
//         "value" => 5
//     ],
//     [
//         "caption" => "KG",
//         "value" => 15
//     ],
// ];

//Each Cartoon contain 5 Box and Each Box contain 15 KG

$uc = new UnitConverter(rel);

print_r($uc->getRootValue([41, 1, 5.5]));

echo "<hr/>";
print_r($uc->getUnitValue(2080.5));
