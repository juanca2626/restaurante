@extends(backpack_view('blank'))

@php
    $week = request()->input('add_weeks') === null ? 'Próxima Semana' : (request()->input('add_weeks') == 1 ? 'Próxima Semana' : 'Semana Actual');
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => "Pedidos por día - $week",
        'content'     => 'Aquí puede ver tus reportes de los pedidos diarios',
         'heading_class' => 'display-3 text-black',
        'content_class' => 'text-black',
    ];
@endphp

@section('content')
  <br><br><br><br><br>  
    @php
        $days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
        $startOfWeek = now()->addWeek()->startOfWeek();
    @endphp      
  <div>
    <div class="mb-5 d-flex gap-2 justify-content-between">
        <a href="{{ route('orders-by-client') }}?add_weeks={{request()->input('add_weeks')}}" class="btn btn-primary">Ir a Pedidos por Cliente</a>
        <form action="{{ route('dashboard') }}">
            <input type="hidden" name="add_weeks" value="{{ request()->input('add_weeks') === null ? 0 : (request()->input('add_weeks') == 1 ? 0 : 1) }}">
            <button class="btn btn-primary">{{ request()->input('add_weeks') === null ? 'Semana Actual' : (request()->input('add_weeks') == 1 ? 'Semana Actual' : 'Próxima Semana')}}</button>
        </form>
    </div>
    <table class="table table-hover table-stripped">
        <thead>            
            @foreach ($days as $index => $day)
                <th>{{ $day }} {{ $monday->copy()->addDays($index)->format('d') }}</th>
            @endforeach
        </thead>
        <tbody>
            <tr>
            @foreach ($days as $index => $day)
                @php
                    $filteredOrders = $orders->filter(fn($x) => $x->delivery_date->dayOfWeek == $index+1)->values();
                @endphp
                <td>
                    @foreach ($filteredOrders->groupBy('dish_id')->values() as $groupedOrders)
                        <div>{{ $groupedOrders->first()->dish->name }} ({{ $groupedOrders->sum('quantity') }})</div>
                    @endforeach
                </td>
            @endforeach
            </tr>
        </tbody>
    </table>
  </div>
@endsection