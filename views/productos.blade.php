@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')

<div class="pagina">


    @foreach($categorias as $categoria)
    @if($categoria['id']==$cat)
    <h1>Productos de categoria {{$categoria['nombre']}}</h1>
    @endif
    @endforeach

    <div class="formulario">
        <div class="contenedor">
            @foreach($productos  as $producto)
            <div class="form-section">
                <form action="index.php" name='producto' method="POST">
                    
                    <label for="id">ID:</label>
                    <input id="id" name="id" type="number" value="{{$producto->getId()}}" readonly="">
                    <label for="nombre">Nombre:</label>
                    <input id="nombre" name="nombre" type="text" value="{{$producto->getNombre()}}">
                    <label for="id">Precio:</label>
                    <input id="precio"  name="Precio" step=0.01 type="number" value="{{$producto->getPrecio()}}">

                    <select id="categoria" name="categoriaProducto">
                        @foreach($categorias as $categoria)
                        @if($producto->getCategoria()==$categoria['id'])
                        <option value="{{$categoria['id']}}" selected>{{$categoria['nombre']}}</option>
                        @else
                        <option value="{{$categoria['id']}}">{{$categoria['nombre']}}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="number" name="categoriaAntigua" value="{{$cat}}" hidden="">
                    <button type="submit" name="modificarProducto" value="{{$producto->getId()}}" >Modificar producto</button>
                    <button type="submit" name="borrarProducto" value="{{$producto->getId()}}" >Eliminar producto</button>

                </form>
            </div>
            @endforeach

            <div class="form-section">
                <p style="color: red;">{{$mensaje}}</p>
            </div>
            <form action="index.php" name='formularioGlobal' method="POST">
                <div class="submit-section">
                    <button class="submit" type="submit" value="{{$cat}}" name="anadirProducto">Añadir Producto</button>
                    <button class="submit" type="submit" value="irinicio" name="irinicio">Ir al Inicio</button>
                </div>
            </form>
        </div>
        @endSection
    </div>