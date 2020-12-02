<?php

namespace AwemaPL\Printer\Sections\Installations\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use AwemaPL\Printer\Facades\Printer;

class Installation
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Printer::canInstallation()){
            $route = Route::getRoutes()->match($request);
            $name = $route->getName();
            if (!in_array($name, config('printer.routes.installation.expect'))){
                return redirect()->route('printer.installation.index');
            }
        }
        return $next($request);
    }
}
