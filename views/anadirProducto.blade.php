@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')

<div class="pagina">

    <h1>Añadir producto</h1>
    <div class="formulario">
        <div class="contenedor">
            <form action="index.php" name='formularioGlobal' method="POST">
                <div class="form-section">
                    <label for="nombre">Nombre:</label>
                    <input id="nombre" name="nombre" type="text" value="">
                    <label for="id">Precio:</label>
                    <input id="precio"  name="Precio" type="number" step=0.01 value="">
                    <input type="number" value='{{$idcategoria}}' name='idcategoria' readonly="">
                </div>

                <div class="form-section">
                    <p style="color: red;">{{$mensaje}}</p>
                </div>
                <div class="submit-section">
                    <input class="submit" type="submit" value="anadir" name="anadir" />
                </div>
            </form>
        </div>
        @endSection
    </div>
