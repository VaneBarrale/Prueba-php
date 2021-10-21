<form action=" {{ url('/empleado') }}" method="post" enctype="multipart/form-data" >  {{--como mando una imagen (fotos, archivos) tengo que agregar el atributo enctype--}}
@csrf

{{--en action {{"sarasa"}} va la ruta a donde voy a enviar info si es que se envia, sino las comillas se dejan vacias 
para saber que es lo que se envia (que tipo de metodo) uso php artisan route:list--}}

{{--para no tener que actualizar la info dos veces, tanto al momento de la edición como
    de la lectura, incluyo ambos formularios en uno solo, en este caso se llama form--}}
@include('empleado.form', ['modo'=>'Crear'])
</form>