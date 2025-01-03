@extends(backpack_view('blank'))

@php
    $week =
        request()->input('add_weeks') === null
            ? 'Próxima Semana'
            : (request()->input('add_weeks') == 1
                ? 'Próxima Semana'
                : 'Semana Actual');
    $widgets['before_content'][] = [
        'type' => 'jumbotron',
        'heading' => "Pedidos por día - $week",
        'content' => 'Aquí puede ver tus reportes de los pedidos diarios',
    ];
@endphp

@section('content')
    @php
        $days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
    @endphp
    <div>
        <div class="mb-5 d-flex gap-2 justify-content-between">
            <a href="{{ route('dashboard') }}?add_weeks={{ request()->input('add_weeks') }}" class="btn btn-primary">Ir a
                Pedidos por Día</a>
            <form action="{{ route('orders-by-client') }}">
                <input type="hidden" name="add_weeks"
                    value="{{ request()->input('add_weeks') === null ? 0 : (request()->input('add_weeks') == 1 ? 0 : 1) }}">
                <button
                    class="btn btn-primary">{{ request()->input('add_weeks') === null ? 'Semana Actual' : (request()->input('add_weeks') == 1 ? 'Semana Actual' : 'Próxima Semana') }}</button>
            </form>
        </div>
        <table class="table table-hover table-stripped">
            <thead>
                <th>Cliente</th>
                @foreach ($days as $index => $day)
                    <th>{{ $day }} {{ $monday->copy()->addDays($index)->format('d') }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($orders->groupBy('customer_id')->values() as $groupedOrders)
                    <tr>
                        <td>{{ $groupedOrders->first()->customer->name }} -
                            {{ $groupedOrders->first()->customer->cellphone }}</td>
                        @foreach ($days as $index => $day)
                            @php
                                $filteredOrders = $groupedOrders
                                    ->filter(fn($x) => $x->delivery_date->dayOfWeek == $index + 1)
                                    ->values();
                            @endphp
                            @if ($filteredOrders->count() > 0)
                                <td>
                                    {{ $filteredOrders->map(fn($x) => $x->dish->name . ($x->quantity == 1 ? '' : " ($x->quantity)"))->implode(', ') }}
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
