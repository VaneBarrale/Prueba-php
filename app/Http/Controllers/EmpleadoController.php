<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Aca consulto los datos que están guardados en la tabla empleados

        $datos['empleados']=Empleado::paginate(5); //entre[] va el nombre de la tabla. paginate(5) pagina de 5 en 5
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //defino los campos que voy a validar
        $campos=[
            'Nombre'=>'required|string|max:100', //es requerido, de tipo string de maximo 100 caracteres
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:1000|mimes:jpeg,png,jpg'
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida'
        ];

        $this->validate($request, $campos, $mensaje);

        //$datosEmpleado = $request->all(); //Obtiene todos los datos de los empleados del formulario
        //Como no quiero recibir el token, lo exceptuo porque no lo tengo en la BD
        $datosEmpleado = $request->except('_token');
        
        //antes de insertar pregunto si me estan enviando una foto, Foto es el id del campo donde se guarda el archivo.
        if($request->hasFile('Foto')){
            //guardo el nombre de la foto, no la ubi donde se almaceno en el proyecto
            $datosEmpleado['Foto']=$request->file('Foto')->store('upload', 'public');
        }

        //Inserto en la base todo lo que recibo
        Empleado::insert($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado agregado con exito');
        //return response()->json($datosEmpleado); //Responde y muestra en formato json lo que se envio desde el formulario.
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //recibo el ID porque es lo que se pasa desde la vista
    {
        
        $empleado = Empleado::findOrFail($id); //findOrFail busca los datos de ese id o por el parametro que busquemos
        return view('empleado.edit', compact('empleado') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[
            'Nombre'=>'required|string|max:100', //es requerido, de tipo string de maximo 100 caracteres
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email'
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida'
        ];

        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:1000|mimes:jpeg,png,jpg'];
            $mensaje=['Foto.required'=>'La foto es requerida'];

        }

        $this->validate($request, $campos, $mensaje);


        //recibo todos los datos del request menos el token y el metodo patch
        $datosEmpleado = $request->except(['_token', '_method']);
        //si actualizo la foto, borro del storage la vieja para que no ocupe lugar al pedo y dsp la reemplazo
        if($request->hasFile('Foto')){
            $empleado=Empleado::FindOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('upload', 'public');
        }

        //pregunto que el id que tengo sea igual al que le paso
        Empleado::where('id', '=', $id)->update($datosEmpleado); 

        //redirecciono al formulario de ese ID con los datos actualizados
        $empleado = Empleado::findOrFail($id); //findOrFail busca los datos de ese id o por el parametro que busquemos
        //return view('empleado.edit', compact('empleado') );
        return redirect('empleado')->with('mensaje', 'Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //tiene que ser consistente con lo que le envio en el index
    {

        $empleado = Empleado::findOrFail($id); 
        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }
        return redirect('empleado')->with('mensaje', 'Empleado borrado');
    }
}
