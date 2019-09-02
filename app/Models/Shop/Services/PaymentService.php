<?php

namespace App\Models\Shop\Services;


use App\Models\Shop\Order\Payment;
use App\Facades\GlobalData;

class PaymentService extends Payment
{
    public function getActiveMethodsWithTax($orderTotalCost)
    {
        $payments = new Payment();

        $services = $payments->getActiveMethods();

        $currencySymbol = GlobalData::getParameter('components.shop.currency.symbol');

        foreach ($services as $service) {
            switch ($service->alias) {
                case 'prepay' :
                    $service->options = [
                        'tax' => 'Без комиссии'
                    ];
                    break;
                case 'card' :
                    $service->options = [
                        'tax' => [
                            round($orderTotalCost * 0.055, 0),
                            $currencySymbol,
                            'Комиссия транспортной компании'
                        ]
                    ];
                    break;
                case 'cash' :
                    $service->options = [
                        'tax' => [
                            round($orderTotalCost * 0.045, 0),
                            $currencySymbol,
                            'Комиссия транспортной компании'
                        ]
                    ];
                    break;
            }
        }

        return $services;
    }
}