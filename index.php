<?php
require __DIR__ . "/UnitConverter.php";

const rel = [
    [
        "caption" => "Cartoon",
        "value" => 1
    ],
    [
        "caption" => "Box",
        "value" => 5
    ],
    [
        "caption" => "KG",
        "value" => 15
    ],
];

$uc = new UnitConverter(rel);
print_r($uc->getRootValue([1, 4, 14]));
echo json_encode($uc->getUnitValue(76));
