@extends('layouts.app')
@section('content')
<div class="container">

    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
    {{Session::get('mensaje') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
            <span arian-hidden="true">&times;</span>
        </button>

    </div>
    @endif

    <a href=" {{ url ('/empleado/create') }}" class="btn btn-success"> Registrar nuevo empleado</a>
    <br>
    <br>

    <table class="table table-light">
        
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            {{--Consulto la info que hay en la tabla empleados--}}

            @foreach ($empleados as $empleado )
            <tr>
                <td>{{ $empleado->id }}</td>
                <td>
                {{--Accedo a la carpeta donde estan las fotos, que es storage. Para eso uso la palabra reservada asset
                    con $empleado.Foto me busca la foto de ese empleado
                    Para que funcione tengo que ejecutar php artisan storage:link--}}
                <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto}}" width="100" alt="">

                </td>
                <td>{{ $empleado->Nombre }}</td>
                <td>{{ $empleado->ApellidoPaterno }}</td>
                <td>{{ $empleado->ApellidoMaterno }}</td>
                <td>{{ $empleado->Correo }}</td>
                <td>
                    <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">
                    Editar
                </a>
                
                | 
                    
                {{--En .$empleado->id le estoy pasando el id del empleado que tengo seleccionado para borrar--}}
                    <form action="{{ url('/empleado/'.$empleado->id) }}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE') }} {{--Convierto el metodo post en delete --}}
                        <input class="btn btn-danger" type="submit" onclick="return confirm('Quieres borrar?')" 
                        value="Borrar">

                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    
    {!! $empleados->links() !!}
    
</div>
@endsection