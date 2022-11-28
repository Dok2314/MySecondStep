<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function weather()
    {
        return view('API.weather.index');
    }

    public function getAjaxWeather(Request $request)
    {
        $city = $request->search;
        $apiKey = '807fe74b369cc6811c5cbb36ec25eaf7';
        $url    = 'https://api.openweathermap.org/data/2.5/weather?q='. $city .'&appid=' . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        $res = json_decode($output);

        return view('API.weather.index', compact('res'));
    }
}
