<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Mail\SendNewOrderMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\DishesResource;
use App\Http\Requests\SaveOrderRequest;

class HomeController extends Controller
{
    public function index(Request $request): View
    {        
        $menu = Menu::orderBy('date')->with('dish')->get();
        $menu = DishesResource::collection($menu)->toJson();
        $extras = Dish::whereType('Entrada')->orderBy('name')->get();
        return view("landing.index", compact("menu", "extras"));
    }

    public function saveOrder(SaveOrderRequest $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $customer = Customer::firstOrCreate(['dni' => $request->dni], [
                'name' => $request->name,
                'cellphone' => $request->cellphone,
                'address' => $request->address,
                'email'=> $request->email,
            ]);
            $customer->update([
                'name' => $request->name,
                'cellphone' => $request->cellphone,
                'address' => $request->address,
                'email' => $request->email,
            ]);
            $sale = Sale::create(['detail' => $request->detail]);
            foreach ($request->cart as $order) {
                $mainOrder = Order::create([
                    'delivery_date' => $order['date'],
                    'customer_id' => $customer->id,
                    'dish_id' => $order['dish_id'],
                    'quantity' => $order['quantity'],
                    'sale_id' => $sale->id
                ]);
                foreach ($order['extra_dishes'] as $extra) {
                    Order::create([
                        'delivery_date' => $order['date'],
                        'customer_id' => $customer->id,
                        'dish_id' => $extra['id'],
                        'quantity' => 1,
                        'sale_id' => $sale->id,
                        'parent_id' => $mainOrder->id
                    ]);
                }
            }        
            Mail::to('rricardo.av@gmail.com')->send(new SendNewOrderMail(collect($request->cart), $customer, $request->detail ?? ''));
            // logger('Admin mail sent');
            // if ($request->email) {
            //     try {
            //         Mail::to($request->email)->send(new SendNewOrderMail(collect($request->cart), $customer, $request->detail ?? ''));
            //         logger('Copy mail sent');
            //     } catch (\Exception $e) {
            //         logger('Error when sending email');
            //     }
            // }
            \DB::commit();
            return response()->json();
        } catch (\Exception $e) {
            \DB::rollBack();
            logger($e);
            return response()->json(['message' => 'Error al registrar, contactese con la empresa'], 422);
        }
    }

    public function getCustomerDataFromDni(Request $request, $dni): JsonResponse
    {
        $customer = Customer::whereDni($dni)->first();
        if (! $customer) {
            return response()->json(['name' => false]);
        }
        return response()->json($customer->toArray());
    }
}
