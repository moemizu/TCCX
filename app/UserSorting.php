<?php

namespace App;


class UserSorting
{
    /**
     * @var array $keyMap - contains all possible key and its initial sorting direction
     */
    private $keyMap;
    /**
     * @var array $userContext - its value should be like ['key1' => 'direction','key2' => 'direction']
     */
    private $userContext;
    private const SORTING_DIRECTION = ['asc', 'desc'];

    private $options = [
        'separator_dir' => ' ',
        'separator_key' => ',',
        'regex_key' => '/[^A-Za-z0-9_$]/'
    ];

    /**
     * @var string $whatToSort cache of whatToSort() method
     */
    private $whatToSort = [];

    public function __construct($keyMap, $userContext, $options = [])
    {
        $this->keyMap = $keyMap;
        if (is_string($userContext))
            $this->userContext = $this->parseSortingQuery($userContext);
        else
            $this->userContext = $userContext;
        array_merge($this->options, $options);
    }

    public function userContext()
    {
        return $this->userContext;
    }

    public function initialKeyMap()
    {
        return $this->keyMap;
    }

    public function whatToSort()
    {
        // cache
        if (!empty($this->whatToSort))
            return $this->whatToSort;
        $keyMap = $this->userContext;
        // merge sorting order
        foreach ($this->keyMap as $key => $value) {
            // merge default sorting order from keyMap
            if (!array_key_exists($key, $keyMap) && $this->isValidKey($key) && $this->isDirection($value)) {
                $keyMap[$key] = $value;
            }
        }
        // filter out null valued item
        foreach ($keyMap as $sortingKey => $value) {
            if (!array_key_exists($sortingKey, $this->keyMap) || !$this->isValidKey($sortingKey) || !$this->isDirection($value))
                unset($keyMap[$sortingKey]);
        }
        return $this->whatToSort = $keyMap;
    }

    public function inverseSortingQuery($selectedKey)
    {
        $finalKeyMap = [];
        // first key to be sorted
        if (array_key_exists($selectedKey, $this->keyMap))
            // retrieve user preference
            $finalKeyMap[$selectedKey] = $this->inverseDirection(array_key_exists($selectedKey, $this->userContext) ?
                $this->userContext[$selectedKey] :
                ($this->isDirection($this->keyMap[$selectedKey]) ?
                    $this->keyMap[$selectedKey] :
                    self::SORTING_DIRECTION[1])
            );
        // the rest of them
        foreach ($this->whatToSort() as $key => $value)
            // if this key is not exists in finalKeyMap
            if (!array_key_exists($key, $finalKeyMap))
                $finalKeyMap[$key] = $value;
        return $this->toQueryString($finalKeyMap);
    }

    public function currentDirection($key, $desiredResult = ['asc', 'desc', ''])
    {
        return [self::SORTING_DIRECTION[0] => $desiredResult[0],
            self::SORTING_DIRECTION[1] => $desiredResult[1],
            'default' => $desiredResult[2]]
        [$this->whatToSort()[$key] ?? 'default'];
    }

    // shorthand method

    public function dir($key, $desiredResult = ['asc', 'desc', ''])
    {
        return $this->currentDirection($key, $desiredResult);
    }

    public function inv($selectedKey)
    {
        return $this->inverseSortingQuery($selectedKey);
    }

    private function toQueryString($arr)
    {
        $query = "";
        foreach ($arr as $key => $value) {
            $query .= $key . $this->options['separator_dir'] . $value . $this->options['separator_key'];
        }
        // trim the last comma
        $query = rtrim($query, $this->options['separator_key']);
        return $query;
    }

    private function isDirection($string)
    {
        return !empty($string) && in_array(strtolower($string), self::SORTING_DIRECTION);
    }

    private function inverseDirection($string)
    {
        return ['asc' => 'desc', 'desc' => 'asc'][strtolower($string)] ?? '';
    }

    private function parseSortingQuery($query)
    {
        // empty string
        if (empty($query)) return [];
        // split key
        $split = explode($this->options['separator_key'], $query);
        if (count($split) <= 0) return [];
        // parsed user context array
        $sortingQuery = [];
        // for every key
        foreach ($split as $item) {
            $arr = explode($this->options['separator_dir'], $item);
            if (count($arr) != 2) continue;
            list($name, $dir) = $arr;
            if ($this->isValidKey($name) && $this->isDirection($dir))
                $sortingQuery[$name] = $dir;
        }
        return $sortingQuery;
    }

    private function isValidKey($key)
    {
        return !preg_match($this->options['regex_key'], $key);
    }

}