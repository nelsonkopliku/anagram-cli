<?php

namespace App;

/**
 * Class AnagramSource
 * @package src
 */
class AnagramSource
{
    /**
     * @var string
     */
    private $input;

    /**
     * Anagram constructor.
     * @param string $input
     */
    private function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * @param string $input
     * @return AnagramSource
     */
    public static function createFromString(string $input) : self
    {
        return new static($input);
    }

    /**
     * @return string
     */
    public function getInput() : string
    {
        return $this->input;
    }

}