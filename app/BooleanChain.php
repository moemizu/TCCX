<?php

namespace App;


class BooleanChain
{
    private $predicate;
    private $subject;

    public function __construct(callable $predicate, $subject)
    {
        $this->predicate = $predicate;
        $this->subject = $subject;
    }

    public function evaluate($keys, $start = false, $or = true)
    {
        $result = $start;
        foreach ($keys as $key) {
            $value = call_user_func($this->predicate, $this->subject, $key);
            if ($or) $result |= $value;
            else $result &= $value;
        }
        return $result;
    }
}