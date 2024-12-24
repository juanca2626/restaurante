<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Hola, se acaba de registrar el siguiente pedido para:</p>
    <ul>
        <li>{{ $customer->name }}, {{ $customer->dni }}, {{ $customer->cellphone }}, {{ $customer->address }}, {{ $customer->email }} </li>
    </ul>
    <p>Con los siguiente platos:</p>
    <ul>
        @php
            $groupedCart = $cart->sortBy('date')->values()->groupBy('date');
            \Carbon\Carbon::setLocale('es');
        @endphp
        @foreach ($groupedCart as $date => $dishes)
            <li> {{ ucfirst(\Carbon\Carbon::parse($date)->translatedFormat('l')) }}: {{ $dishes->map(fn($x) => $x['quantity'].' '.$x['name'])->implode(', ') }} </li>
        @endforeach
    </ul>
    @if ($detail)
        <p>Detalles:</p>
        <p>{{ $detail }}</p>        
    @endif
</body>
</html>