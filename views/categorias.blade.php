@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')

<div class="pagina">
    <h1>Catalogo</h1>
    <form class="formulario" name="juego" action="index.php" method="POST">
        <div class="contenedor">
            <h2>Elige alguno</h2>
            @foreach($catalogo  as $categoria)
            <div class="form-section">
                <button type="submit" name="categoria" value="{{$categoria['id']}}">{{$categoria['nombre']}}</button>
            </div>
            @endforeach
            <div class="form-section">
                <p style="color: red;">{{$mensaje}}</p>
            </div>
            <div class="submit-section">
                <input class="submit" type="submit" 
                       value="salir" name="salir" /> 
            </div>

        </div>
</div>
</form>
@endSection
