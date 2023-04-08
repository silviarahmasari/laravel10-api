<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SakilaResource;
use App\Models\Customer;
use App\Models\Rental;
use App\Models\Inventory;
use App\Models\Film;

class RentalHistoryController extends Controller
{
    public function store(Request $customer_id)
    {
        if(!$customer_id->exists('customer_id')) {
            return new SakilaResource(false, 'GLO0001', "Bad Request - Parameter 'customer_id' is not found", null);
        }

        $customer = Customer::where('customer_id', $customer_id->customer_id)->first();
        if(!$customer){
            return new SakilaResource(false, 'CUS0001', "Provided 'customer_id' is not found", null);
        }

        $rental = Rental::where('customer_id', $customer->customer_id)->get();
        $rental_count = count($rental); //23
        for ( $i = 0; $i < $rental_count; $i++) {
            $rental_history = Rental::select('film.title', 'rental.rental_date', 'rental.return_date')
            ->join('inventory', 'inventory.inventory_id', 'rental.inventory_id')
            ->join('film', 'film.film_id', 'inventory.film_id')
            ->where('customer_id', $rental[$i]->customer_id)
            ->orderBy('rental.rental_date', 'DESC')
            ->get();
        }
        $customer->rental_history=$rental_history ;

        return new SakilaResource(true, '200', "Succesfully get customer's rental history", $customer);
    }
}
