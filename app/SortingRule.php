<?php

namespace App;

/**
 * Class SortingRule
 * Use for validating and parsing sorting rule
 * TODO: More validation
 * @package App
 */
class SortingRule
{
    public const DIRECTIONS = ['asc', 'desc'];
    /** @var array $availableKeys All key available */
    private $availableKeys;

    /** @var string $defaultKey default key */
    private $defaultKey;

    /** @var string $defaultDirection default direction */
    private $defaultDirection;

    /**
     * SortingRule constructor.
     * @param array $keys All possible key for sorting
     * @param string $defaultKey default key, if user supplied input is invalid
     * @param string $defaultDirection default direction
     */
    public function __construct($keys, $defaultKey, $defaultDirection = self::DIRECTIONS[0])
    {
        $this->availableKeys = $keys;
        $this->defaultKey = $defaultKey;
        $this->defaultDirection = $defaultDirection;
    }

    /**
     * Return pair of key and direction from user input
     * return default value with ascending direction if input is invalid
     * @param string $inputKey user input
     * @return array ['key', 'direction'] direction is either 'asc' or 'desc'
     */
    public function keyOrDefault(string $inputKey): array
    {
        // default value
        $key = $this->defaultKey;
        $direction = $this->defaultDirection;
        // clear case
        $inputKey = strtolower($inputKey);
        // split input
        $explode = explode(':', $inputKey);
        // default if not present
        $inputKey = $explode[0] ?? '';
        $inputDirection = $explode[1] ?? '';
        // check if key is valid
        if (in_array($inputKey, $this->availableKeys)) {
            $key = $inputKey;
        }
        // check if direction is valid
        if (in_array($inputDirection, self::DIRECTIONS)) {
            $direction = $inputDirection;
        }
        return [$key, $direction];
    }
}