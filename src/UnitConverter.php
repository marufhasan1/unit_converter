<?php

namespace Unitconverter;

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
                $total = intval($quantities[$key]);

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
    public function getUnitValue(int $quantity): array
    {
        $relation_v = $this->r_v;
        $unitOut = [];
        foreach ($relation_v as $value) {
            array_shift($relation_v);
            $multip_r_v = array_product($relation_v); //Multiplication of ramaining relational value of array;

            $unitQty = intval($quantity / $multip_r_v);
            $unitOut[] = $unitQty;
            $quantity -= $unitQty * $multip_r_v;
        }


        $unitSet = array_map(function ($caption, $key) use ($unitOut) {
            return [
                "caption" => $caption,
                "value" => $unitOut[$key]
            ];
        }, $this->captions, array_keys($this->captions));

        return $unitSet;
        // return $unitOut;
    }
}
