@extends('partials/plantillaServicios')
@section('rutaJs','../js/chatYEncuestas.js')
@section('categorias')
@section('pusher')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection
@php 
    $portal=Session::get('portal')
@endphp

<div id="chatCat" class="flex-grow flex justify-center cursor-pointer hover:text-colorDetalles">
    <span class="h-full flex flex-col justify-center @if ($ruta=='chat') border-b-4 border-white  selected @endif">Chat</span>
</div>
<div id= "encuestasCat"class="flex-grow flex justify-center cursor-pointer  hover:text-colorDetalles ">
    <span class="h-full flex flex-col justify-center @if ($ruta=='encuestas') border-b-4 border-white  selected @endif">Encuestas</span>
</div>

@endsection



@section('contenidoServicio')



<section id="chat" class=" @if ($ruta=='chat') mostrar flex @else hidden @endif  items-start  md:items-stretch h-full w-full">
<img src="{{asset('imagenes/imagenesBasic/imagenMenu.svg')}}" alt="" class="open md:hidden w-14">

    @livewire('chat.lista-chats')
    @livewire('chat.contenedor-mensajes')
</section>

<section id="encuestas" class=" @if ($ruta=='encuestas') mostrar flex @else hidden @endif h-full w-full">
    <div class="encuestas w-full h-full flex flex-col">
        <div class="botonesEncuestas flex justify-center">
            @if($participanteActual->admin||!$ajustes->crear_encuesta)
            <button class="bg-colorBarra2 text-white p-4 rounded-xl mx-4 creadorEncuestas">Crear encuesta</button>
            @endif
            <button class="bg-colorBarra2 text-white p-4 rounded-xl mx-4 cambioEncuestas">Encuestas finalizadas</button>
        </div>
    
        <div class="listadoEncuestas border-4 overflow-y-auto relative grow">


           <table class=" w-full h-full flex-row flex md:table">
                <thead class=" border-4 sticky top-0">
                    <tr class="flex flex-col md:table-row h-full justify-evenly">
                        <th>Encuesta</th>
                        <th>Descripción</th>
                        <th>Creador</th>
                        <th>Participantes</th>
                        <th>Porcentajes</th>
                        <th>Votos</th>
                        <th>Fecha fin</th>
                        <th><button>Votar</button></th>
                    </tr>
                </thead>
                <tbody class="border-4 border-solid border-blue-700 h-full tablaNoFinalizados flex md:table-row-group text-sm all-tr:w-[30%]">
                     @foreach ($encuestas as $encuesta) 
                        <tr class="md:h-32 h-full flex flex-col justify-evenly md:table-row hover:bg-colorComplem text-white bg-colorCaberaTras all-td:border-2 all-td:border-colorCaberaTras2 ">
                            <td>{{$encuesta->title}}</td>
                            <td><button value="descripcion" class="btn-info leerDescripcion truncate max-w-64">{{$encuesta->descripcion}}</button></td>
                            <td >{{$encuesta->creador}}</td>
                            <td class="text-center w-40"><button value="participantes" class="btn-info md:p-2 text-[6px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Ver participantes</button></td>
                            <td class="text-center"><button value="opciones_votos" class="btn-info md:p-2 text-[6px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Ver porcentajes</button></td>   {{-- btn-info --}}
                            <td>{{$encuesta->num_votos_hechos}}/{{$encuesta->num_votos_totales}}</td>
                            <td>{{$encuesta->fecha_final?$encuesta->fecha_final:'Sin fecha'}}</td>
                            <td class="text-center"><button class="mostrarVotacion md:p-2 text-[8px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Votar</button></td>
                            <input type="hidden" value="{{$encuesta->id}}">
                        </tr>
                    @endforeach 
                </tbody>
                <tbody class="border-4 border-solid hidden md:hidden border-blue-700 h-full tablaFinalizados flex md:table-row-group">
                     @foreach ($encuestasF as $encuesta) 
                        <tr class="h-32 flex flex-col md:table-row hover:bg-colorComplem text-white bg-colorCaberaTras all-td:border-2 all-td:border-colorCaberaTras2 ">
                            <td>{{$encuesta->title}}</td>
                            <td><button value="descripcion" class="btn-info leerDescripcion truncate max-w-64">{{$encuesta->descripcion}}</button></td>
                            <td >{{$encuesta->creador}}</td>
                            <td class="text-center"><button value="participantes" class="btn-info md:p-2 text-[8px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Ver participantes</button></td>
                            <td class="text-center"><button value="opciones_votos" class="btn-info md:p-2 text-[8px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Ver porcentajes</button></td>   {{-- btn-info --}}
                            <td>{{$encuesta->num_votos_hechos}}/{{$encuesta->num_votos_totales}}</td>
                            <td>{{$encuesta->fecha_final?$encuesta->fecha_final:'Sin fecha'}}</td>
                            <td class="text-center"><button class="mostrarVotacion md:p-2 text-[8px] p-1 leading-[0.6rem] md:text-base bg-white rounded-full hover:bg-colorDetalles text-black">Votar</button></td>
                            <input type="hidden" value="{{$encuesta->id}}">
                        </tr>
                    @endforeach 
                </tbody>
            </table>



            <div class="formEncuesta hidden flex justify-center  w-full h-full absolute top-0 overflow-y-auto">
                <form action="{{route('newEncuesta')}}" method="POST" class="formularioEncuestas bg-colorBarra2 md:w-[40%] w-[70%] h-[480px] fixed overflow-y-auto flex flex-col items-center">
                    @csrf
                    <div class="flex all-div:w-[40%] justify-around items-center">
                        <div>
                            <label for="titulo">Titulo </label>
                            <input type="text" id="titulo" name="tittle" class="w-[100%]" required>
                        </div>
                        <div>
                            <label for="fecha_final">Fecha(opcional)</label>
                            <input type="date" id="fecha_final" name="fecha_final">
                        </div>
                    </div>

                    <label for="descripcion">Descripción</label>
                    <div class="h-[20%]">
                        <textarea name="descripcion" type="text" id="descripcion"></textarea>
                    </div>
                    
                    <div class="overflow-y-auto px-5">
                        <div>
                            <label for="allParticipantes">Votan todos</label>
                            <input type="checkbox" id="allParticipantes" name="allParticipantes" required>
                        </div>
                         <div class="">
                            <label for="one2Many">Pueden votar:</label>
                            <input type="checkbox" id="one2Many" name="one2Many">
                        </div>
                        <div class="seleccionados hidden">
                            @foreach ($participantes as $participante) 
                            <div class="h-[40%]">
                                @if ($participante->nombre_en_portal==$participanteActual->nombre_en_portal)
                                <div class="hover:bg-colorComplem text-white hover:text-black">
                                    <label for="{{$participante->nombre_en_portal}}" >{{$participante->nombre_en_portal}}(Tú)</label>
                                    <input type="checkbox" id="{{$participante->nombre_en_portal}}" class="individual" name="individual[]" value="{{$participante->nombre_en_portal}}">    
                                </div>    
                                @else
                                <div class="hover:bg-colorComplem text-white hover:text-black">
                                    <label for="{{$participante->nombre_en_portal}}" >{{$participante->nombre_en_portal}}</label>
                                    <input type="checkbox" id="{{$participante->nombre_en_portal}}" class="individual" name="individual[]" value="{{$participante->nombre_en_portal}}">    
                                </div>  
                                @endif 
                            </div>
                            @endforeach 
                        </div>
                    </div>
                    <div class="opcionesContainer flex flex-col overflow-y-auto justify-around h-20 my-10">
                        <input type="text" placeholder="Opcion de encuesta" class="opciones_votos" name="opciones_votos[]" class="h-25%" required>
                        <input type="text" placeholder="Opcion de encuesta" class="opciones_votos" name="opciones_votos[]" class="h-50%" required>
                        
                </div>
                
                <button type="button" class="crearInputs bg-colorComplem rounded-3xl p-1 mb-4">Crear más</button>
                <button type="submit" class=" enviarFormulario p-2 mb-2 bg-colorComplem rounded-3xl hover:bg-colorDetalles hover:text-white">Guardar Encuesta</button>
                </form>
            </div>


            

            <div class="contenedorMuestraInfo hidden absolute bottom-0 flex justify-center items-center w-full h-full">
                <div class="fixed bg-colorBarra2 md:w-[30%] w-[50%] h-[40%] ">
                    <figure class="w-10 absolute z-20 top-[2%] left-[2%] btn-cerrar "><img src="{{asset('imagenes/imagenesBasic/cerrar.png')}}" alt=""></figure>
                    <div class="muestraInfo p-4 flex flex-col  w-full h-full overflow-x-auto items-center justify-around "></div>
                </div>
            </div>
            <div class="contenedorMuestraInfo2 hidden absolute bottom-0 flex justify-center items-center w-full h-full" >
                <div class="fixed bg-colorBarra2 md:w-[50%] w-[70%] h-[30%] pb-10  overflow-hidden">
                    <figure class="w-10 absolute z-20 top-[2%] left-[2%] btn-cerrar2">
                        <img src="{{asset('imagenes/imagenesBasic/cerrar.png')}}" alt="">
                    </figure>
                    <div class="muestraInfo2 mt-10 flex flex-col w-full h-full overflow-y-auto justify-items-center items-center"></div>
                </div>
            </div>
            <div class="encuestas absolute hidden bottom-0 flex justify-center items-center w-full h-full">
                <div class="fixed bg-colorBarra2 md:w-[50%] w-[70%] h-[50%] pb-10 overflow-y-auto flex flex-col justify-start items-center ">
                    <figure class="w-10 absolute z-20 top-[2%] left-[2%] btn-cerrar3">
                        <img src="{{asset('imagenes/imagenesBasic/cerrar.png')}}" alt="">
                    </figure>
                    <h2 class="my-5 font-extralight text-white">Elige la opción que quieras votar</h2>
                        <div class="opcionesVotacion w-[80%] text-center">
                            
                        </div>
                        <div class=" containerMensaje fixed hidden  bottom-[15%] w-[45%] h-[10%] bg-colorSecundario flex justify-center items-center rounded-3xl text-white"></div>
                </div>
            </div>
        </div>
        
</section>

@endsection