<?php

if (!function_exists('setActive')) {
    function setActive($route)
    {
        return request()->routeIs($route) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white';
    }
}
