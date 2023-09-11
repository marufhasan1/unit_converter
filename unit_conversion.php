<?php 
	// const labels= ["Cartoon"];
    // const relation = [1];
	const labels= ["Cartoon","Box","KG"];
    const relation = [1, 5, 15];
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


	$quantities = [149];
	$small_amount = 0;

// Get smaller Quantity Start Here
$allSmalleramounts = [];

foreach (relation as $key => $value) {
    if(isset($quantities[$key])){
        $total = intval($quantities[$key]);
    
        for($index = $key + 1; $index <= count(relation)-1; $index++) {
            $total *= relation[$index];
        }
    
        $allSmalleramounts[] = $total;
    }
}
// foreach ($quantities as $key => $amount) {
// 	$total = intval($amount);

// 	for($index = $key + 1; $index <= count($quantities)-1; $index++) {
// 		$total *= relation[$index];
// 	}

// 	$allSmalleramounts[] = $total;
// }

$smQty = array_sum($allSmalleramounts);
// print_r($allSmalleramounts);
echo "Smaller Unit: ". $smQty.PHP_EOL ."<br>";
// Get Smaller Quantity End Here

$rrr = relation;
$unitOut = [];
foreach($rrr as $value){
    array_shift($rrr);

    $unitQty = intval($smQty / array_product($rrr));
    $unitOut[] = $unitQty;
    $smQty -= $unitQty * array_product($rrr);
}

// Reverse Output into Unit
print_r($unitOut);