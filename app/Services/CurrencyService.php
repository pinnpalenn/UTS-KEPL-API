<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    protected $apiKey;
    protected $baseUrl = 'https://openexchangerates.org/api';

    public function __construct()
    {
        $this->apiKey = env('OPEN_EXCHANGE_RATES_APP_ID');
    }

    public function getCurrencies()
    {
        return Cache::remember('currencies_list', 86400, function () {
            $response = Http::get("{$this->baseUrl}/currencies.json");
            return $response->json();
        });
    }

    public function getLatestRates()
    {
        return Cache::remember('latest_rates', 3600, function () {
            $response = Http::get("{$this->baseUrl}/latest.json", [
                'app_id' => $this->apiKey
            ]);
            return $response->json();
        });
    }

    public function convert($amount, $from, $to)
    {
        $rates = $this->getLatestRates();

        if (!isset($rates['rates'][$from]) || !isset($rates['rates'][$to])) {
            return null;
        }

        // Convert from source currency to USD (base currency)
        $amountInUsd = $amount / $rates['rates'][$from];

        // Convert from USD to target currency
        $amountInTargetCurrency = $amountInUsd * $rates['rates'][$to];

        return round($amountInTargetCurrency, 2);
    }
}
