<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $currencies = $this->currencyService->getCurrencies();
        return view('currency.index', compact('currencies'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
        ]);

        $amount = $request->input('amount');
        $fromCurrency = $request->input('from_currency');
        $toCurrency = $request->input('to_currency');

        $convertedAmount = $this->currencyService->convert($amount, $fromCurrency, $toCurrency);

        if ($request->ajax()) {
            return response()->json([
                'result' => $convertedAmount,
                'from' => $fromCurrency,
                'to' => $toCurrency,
                'amount' => $amount
            ]);
        }

        $currencies = $this->currencyService->getCurrencies();
        return view('currency.index', compact('currencies', 'convertedAmount', 'fromCurrency', 'toCurrency', 'amount'));
    }
}
