<?php

namespace Tests\Unit;

use App\SortingRule;
use Tests\TestCase;


class SortingRuleTest extends TestCase
{
    /**
     * Test rule processing
     * @dataProvider rulesProvider
     * @return void
     */
    public function testRule($input, $expected)
    {
        $rule = new SortingRule(['name', 'id', 'order', 'score'], 'score');
        $this->assertSame($rule->keyOrDefault($input), $expected);
    }

    public function rulesProvider()
    {
        return [
            ['name', ['name', 'asc']],
            ['name:desc', ['name', 'desc']],
            ['score:asc', ['score', 'asc']],
            ['id', ['id', 'asc']],
            [':', ['score', 'asc']],
            [':desc', ['score', 'desc']],
            [':asc', ['score', 'asc']],
            ['name:', ['name', 'asc']],
            ['', ['score', 'asc']]
        ];
    }

    /**
     * Test if it return correct default direction
     * @return void
     */
    public function testRuleDirection()
    {
        $rule = new SortingRule(['name', 'id', 'order', 'score'], 'score', 'desc');
        $this->assertSame($rule->keyOrDefault(''), ['score', 'desc']);
    }
}
