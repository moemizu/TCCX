<?php

namespace App\Http\Middleware;

use Closure;
use Lavary\Menu\Builder;

/**
 * Class GenerateMenus
 * use for menu generation
 * @package App\Http\Middleware1
 */
class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // tccx menu
        \Menu::make('tccx', function (Builder $menu) {
            $menu->add('Home');
            $menu->add('About', ['url' => 'about']);
            $menu->add('Scoreboard', ['url' => 'scoreboard']);
        });
        return $next($request);
    }
}
