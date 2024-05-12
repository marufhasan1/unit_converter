<?php
class UnitConverter
{
    private $captions = []; //Captions
    private $r_v = []; //Relational Value

    /**
     * @param iterable $label_value
     */
    public function __construct(iterable $label_value)
    {
        $this->captions = array_column($label_value, "caption");
        $this->r_v = array_column($label_value, "value");
    }


    /**
     * @param iterable $label_value
     * 
     * @return [type]
     */
    public function __invoke(iterable $label_value)
    {
        $this->captions = array_column($label_value, "caption");
        $this->r_v = array_column($label_value, "value");
    }

    /**
     * @param iterable $quantities
     * 
     * @return array
     */
    public function getRootValue(iterable $quantities): array
    {
        $collect_root_values = [];
        foreach ($this->r_v as $key => $value) {
            if (isset($quantities[$key])) {
                $total = floatval($quantities[$key]);

                for ($index = $key + 1; $index <= count($this->r_v) - 1; $index++) {
                    $total *= $this->r_v[$index];
                }

                $collect_root_values[] = $total;
            }
        }

        $smQty = array_sum($collect_root_values);
        return [
            "caption" => end($this->captions),
            "value" => $smQty
        ];
    }

    /**
     * @param int $quantity
     * @return array
     * This Function will return details unit value with corresponding label
     * 
     */
    // public function getUnitValue(float $quantity): array
    // {
    //     $relation_v = $this->r_v;
    //     $unitOut = [];
    //     foreach ($relation_v as $value) {
    //         print_r($relation_v);

    //         array_shift($relation_v);
    //         // print_r($relation_v);
    //         $multip_r_v = array_product($relation_v); //Multiplication of ramaining relational value of array;

    //         $unitQty = intval($quantity / $multip_r_v);
    //         $quantity -= $unitQty * $multip_r_v;
    //         // $is_last_fraction = ($quantity < 1);
    //         $unitOut[] = $unitQty;

    //         // taking the last unit's decimal places.
    //         // $unitOut[] = ($is_last_fraction) ? ($unitQty + $quantity) : $unitQty;

    //         // echo $unitQty . "=" . $quantity . "|";
    //     }


    //     $unitSet = array_map(function ($caption, $key) use ($unitOut) {
    //         return [
    //             "caption" => $caption,
    //             "value" => $unitOut[$key]
    //         ];
    //     }, $this->captions, array_keys($this->captions));

    //     return $unitSet;
    //     // return $unitOut;
    // }

    public function getUnitValue(float $quantity): array
    {
        $relation_v = $this->r_v;
        $unitOut = [];

        foreach ($relation_v as $value) {
            array_shift($relation_v);
            $multip_r_v = array_product($relation_v); // Multiplication of remaining relational values.

            $unitQty = floor($quantity / $multip_r_v); // Calculate the integer part of the division.
            $quantity -= $unitQty * $multip_r_v; // Subtract the integer part from the quantity.

            // Append the integer part to the output array.
            $unitOut[] = $unitQty;
        }

        // Append the remaining quantity (fractional part) to the last unit value.
        $unitOut[count($unitOut) - 1] += $quantity;

        $unitSet = array_map(function ($caption, $key) use ($unitOut) {
            return [
                "caption" => $caption,
                "value" => $unitOut[$key]
            ];
        }, $this->captions, array_keys($this->captions));

        return $unitSet;
    }
}
