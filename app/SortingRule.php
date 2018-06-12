<?php

namespace App;

/**
 * Class SortingRule
 * Use for validating and parsing sorting rule
 * @package App
 */
class SortingRule
{
    public const DIRECTIONS = ['asc', 'desc'];
    /** @var array $availableKeys All key available */
    private $availableKeys;

    /** @var string $defaultKey default key */
    private $defaultKey;

    public function __construct($keys, $defaultKey)
    {
        $this->availableKeys = $keys;
        $this->defaultKey = $defaultKey;
    }

    public function keyOrDefault($inputKey)
    {
        // default value
        $key = $this->defaultKey;
        $direction = self::DIRECTIONS[0];
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