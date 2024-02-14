@extends('main')
@section('content')
<table>
    @foreach ($tablero as $i => $columna)
    <tr>
        @foreach ($columna as $j => $imagen) 
        <td><img src="{{$imagen}}" alt="alt" data-x="{{ $i }}" data-y="{{ $j }}" id="{{ $i . $j }}"/></td>
        @endforeach
    </tr>
    @endforeach
</table>
@endsection


