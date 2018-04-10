<?php

namespace App;

/**
 * Class AnagramCalculator
 * @package src
 */
class AnagramCalculator
{
    /**
     * @param AnagramSource $source
     * @return array
     */
    public function getAnagramsForSource(AnagramSource $source) : array
    {
        return $this->permute($source->getInput());
    }

    /**
     * @param $arg
     * @return array
     */
    private function permute($arg) : array
    {
        $array = \is_string($arg) ? str_split($arg) : $arg;
        if (1 === \count($array)) {
            return $array;
        }
        $result = [];
        foreach ($array as $key => $item) {
            foreach ($this->permute(array_diff_key($array, [$key => $item])) as $p) {
                $result[] = $item . $p;
            }
        }
        return $result;
    }

}