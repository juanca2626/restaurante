<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'numeric', function ($attribute, $value, $fail) {
                $customer = Customer::whereDni(request()->input('dni'))->first();
                if (!$customer) { return; }
                $monday = now()->startOfWeek();
                $friday = $monday->copy()->addWeek()->format('Y-m-d');
                $orders = Order::whereBetween('created_at', [$monday->format('Y-m-d'), $friday])->whereCustomerId($customer->id)->count();
                if ($orders > 0) {
                    return $fail('Usted ya realizó su pedido de la semana. Si desea modificarlo contáctese con la empresa');
                }
            }],
            'name' => [function ($attribute, $value, $fail) {
                $customer = Customer::whereDni(request()->input('dni'))->first();
                if (!$customer && !$value) {
                    return $fail('Debe llenar su nombre');
                }
            }],
            'address' => [
                function ($attribute, $value, $fail) {
                    $customer = Customer::whereDni(request()->input('dni'))->first();
                    if (!$customer && !$value) {
                        return $fail('Debe llenar su dirección');
                    }
                }
            ],
            'cellphone' => [
                function ($attribute, $value, $fail) {
                    $customer = Customer::whereDni(request()->input('dni'))->first();
                    if (!$customer && !$value) {
                        return $fail('Debe llenar su celular');
                    }
                },                
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El dni es obligatorio',
            'dni.numeric' => 'El dni debe ser un número',
            'cellphone' => 'El teléfono debe ser un número',
        ];
    }
}
