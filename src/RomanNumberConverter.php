<?php

namespace App;

class RomanNumberConverter
{

    public function convert(int $num): string
    {
        return "I";
    }

    public function convert($arabic) {
        $this->validate($arabic);
        $romanNumberSolution = "";
        foreach ($this->romanNumberMap as $arabicValue => $romanValue) {
            while ($arabic >= $arabicValue) {
                $romanNumberSolution.= $romanValue;
                $arabic-= $arabicValue;
            }
        }
        return $romanNumberSolution;
    }

    private function validate($arabic) {
        if (!is_numeric($arabic) || $arabic < 1) {
            throw new \InvalidArgumentException();
        }
    }
}