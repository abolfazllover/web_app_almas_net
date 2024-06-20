<?php

use Illuminate\Support\Facades\Cookie;

function saveCookie($name, $value, $minutes = 60) {
    $cookie = Cookie::make($name, $value, $minutes);
    Cookie::queue($cookie);
}

function getCookie($name) {
    return Cookie::get($name);
}

function api_url(): string
{
    return "http://localhost/almas/crm/api";
}
