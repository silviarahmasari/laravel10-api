<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Address;
use App\Http\Resources\SakilaResource;

class StoreStatisticController extends Controller
{
    public function index()
    {
        $store = Store::withCount('customer')->get();
        $address = Store::with('address:address_id,address AS store_address')->get();
        for ($i = 0; $i < count($store); $i++) {
            $data[$i] = [
                'store_id'          => $store[$i]->store_id,
                'store_address'     => $address[$i]->address->store_address,
                'customer_count'    => $store[$i]->customer_count
            ];
        }
        return new SakilaResource(true, '200', 'Succesfully get store statistic', $data);
    }

    public function show($store_id)
    {
        $store = Store::withCount('customer')->with('address')->where('store_id', '=', $store_id)->get();

        if ($store->isEmpty()) {
            return new SakilaResource(false, 'STO0001', "Provided 'store_id' is not found", null);
        } else {
            for ($i = 0; $i < count($store); $i++) {
                $data[$i] = [
                    'store_id'          => $store[$i]->store_id,
                    'store_address'     => $store[$i]->address->address,
                    'customer_count'    => $store[$i]->customer_count,
                    'address_detail'    => [
                        'address_id'    => $store[$i]->address_id,
                        'address'       => $store[$i]->address->address,
                        'address2'      => $store[$i]->address->address2,
                        'district'      => $store[$i]->address->district,
                        'city_id'       => $store[$i]->address->city_id,
                        'postal_code'   => $store[$i]->address->postal_code,
                        'phone'         => $store[$i]->address->phone,
                    ]
                ];
            }
        }
        return new SakilaResource(true, '200', 'Succesfully get store statistic', $data);
    }
}
