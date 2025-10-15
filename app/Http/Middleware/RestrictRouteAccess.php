<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use App\Classes\User;
class RestrictRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next){
        // Get the current route name and its prefix
        $currentRouteName = $request->route()->getName();
        $currentRoutePrefix = $this->getPrefixForRoute($currentRouteName);
        // dump($currentRoutePrefix);
        $routeNamesFromDb = $this->getRouteNamesFromDatabase();
        $routePrefixesFromDb = $this->getPrefixesForRoutes($routeNamesFromDb);
        // dd($routePrefixesFromDb);
        // Compare the current route's prefix with those from the database
        if (in_array($currentRoutePrefix, $routePrefixesFromDb)) {
            // Prefix matches
            return $next($request);
        }

        // Prefix does not match, handle accordingly (e.g., redirect or abort)
        return abort(404); // Example redirection
    }

    protected function getPrefixForRoute($routeName)
    {
        $routePrefixes = $this->getRoutePrefixes();
        return $routePrefixes[$routeName] ?? null;
    }

    function getRoutePrefixes()
    {
        $prefixes = [];

        foreach (Route::getRoutes() as $route) {
            $name = $route->getName();
            $uri = $route->uri();
            
            if ($name) {
                // Extract prefix from the URI
                $prefix = explode('/', $uri)[0]; // Get the first segment of the URI as prefix
                $prefixes[$name] = $prefix;
            }
        }

        return $prefixes;
    }

    protected function getRouteNamesFromDatabase()
    {
        $user = new User;
        $userCards = $user->getSideBarCards();
        $routeNamesFromDb = $userCards['parent_cards']
                                ->merge($userCards['child_cards'])
                                ->whereNotNull('action_route')
                                ->pluck('action_route')
                                ->toArray();
        
        return $routeNamesFromDb;
    }

    protected function getPrefixesForRoutes(array $routeNames)
    {
        $prefixes = [];
        foreach ($routeNames as $routeName) {
            $prefix = $this->getPrefixForRoute($routeName);
            if ($prefix) {
                $prefixes[] = $prefix;
            }
        }

        $prefixes = array_merge($prefixes, ['', 'user', 'index', 'lang']);
        if(
            (
                in_array('partners', $prefixes)
                    ||
                in_array('clients', $prefixes)
            ) 
            &&
            !in_array('partners-or-clients', $prefixes)
        ){
            $prefixes = array_merge($prefixes, ['partners-or-clients']);
        }
        return $prefixes;
    }
    
}
