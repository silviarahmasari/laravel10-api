<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Resources\SakilaResource;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class StoreRevenueController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:inventory',
            'start_date' => 'date|date_format:Y-m-d',
            'end_date' => 'date|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return new SakilaResource(false, 'GLO0001', "Bad Request - Parameter 'store_id' is not found", null);
        }

        if ($request->has('start_date')){
            $start_date = $request->start_date;
        } else {
            $start_date = $request->start_date ? $request->start_date : "1970-01-01";
        }
        if ($request->has('end_date')) {
            $end_date = $request->end_date;
        } else {
            $end_date = $request->end_date ? $request->end_date : Carbon::now();
        }

        $store = Rental::select('inventory.store_id', 'payment.amount', 'rental.rental_date')
        ->join('payment', 'payment.rental_id', 'rental.rental_id')
        ->join('inventory', 'inventory.inventory_id', 'rental.inventory_id')
        ->where('inventory.store_id', '=', $request->store_id)
        ->whereBetween('rental_date', [$start_date, $end_date])
        ->get();

        for ($i = 0; $i < count($store); $i++) {
            $sum = $store[$i]->amount + $i;
        }

        $revenue = Rental::select('inventory.store_id', 'payment.payment_id', 'payment.amount', 'rental.rental_date', 'rental.return_date', 'film.title', 'film.rental_rate')
            ->join('payment', 'payment.rental_id', 'rental.rental_id')
            ->join('inventory', 'inventory.inventory_id', 'rental.inventory_id')
            ->join('film', 'film.film_id', 'inventory.film_id')
            ->where('inventory.store_id', '=', $request->store_id)
            ->whereBetween('rental_date', [$start_date, $end_date])
            ->get();

        for ($i = 0; $i < count($revenue); $i++)
        {
            $rev[$i] = [
                'payment_id'        => $revenue[$i]->payment_id,
                'amount'            => '$'.$revenue[$i]->amount,
                'rental_date'       => $revenue[$i]->rental_date,
                'return_date'       => $revenue[$i]->return_date,
                'movie_title'       => $revenue[$i]->title,
                'movie_rental_rate' => $revenue[$i]->rental_rate,
            ];
        }
        $data = [
            'store_id'      => $request->store_id,
            'total_revenue' => '$'.$sum,
            'details'       => $rev
        ];

        return new SakilaResource(true, '200', 'Succesfully get data from '.$start_date.' to '.$end_date, $data);
    }
}
