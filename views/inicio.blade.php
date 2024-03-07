@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')

<div class="pagina">
    <h1>Inicio de sesion</h1>
    <form class="formulario" name="juego" action="index.php" method="POST">
        <div class="contenedor">
            <div class="form-section">
                <input id="nombre" type="text" name="nombre" value="{{$nombre}}" placeholder="Usuario"/>
            </div>
            <div class="form-section">
                <input id="contrasena" type="password" name="contrasena" value="{{$contrasena}}" placeholder="Contraseña"/>
            </div>
            
            <div class="form-section">
                <p style="color: red;">{{$mensaje}}</p>
            </div>
            <div class="submit-section">
                <input class="submit" type="submit" 
                       value="iniciarSesion" name="iniciarSesion" /> 
            </div>
        </div>
</div>
</form>
@endSection
