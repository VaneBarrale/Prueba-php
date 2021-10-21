Mostrar la lista de empleados 
<br>
<a href=" {{ url ('/empleado/create') }}"> Registrar nuevo empleado</a>
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
            <img src="{{ asset('storage').'/'.$empleado->Foto}}" width="100" alt="">

            </td>
            <td>{{ $empleado->Nombre }}</td>
            <td>{{ $empleado->ApellidoPaterno }}</td>
            <td>{{ $empleado->ApellidoMaterno }}</td>
            <td>{{ $empleado->Correo }}</td>
            <td>
                <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}">
                Editar
            </a>
            
            | 
                
            {{--En .$empleado->id le estoy pasando el id del empleado que tengo seleccionado para borrar--}}
                <form action="{{ url('/empleado/'.$empleado->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }} {{--Convierto el metodo post en delete --}}
                    <input type="submit" onclick="return confirm('Quieres borrar?')" 
                    value="Borrar">

                </form>

            </td>
        </tr>
        @endforeach
    </tbody>

</table>