@extends('welcome')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<br>
<h2 align="center" style="color: #1e73be"><b>ADMINISTRADOR DE ORDENES</b></h2>
<br>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearOrdenModal">
        <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;</i><b>Crear Orden</b>
        </button>
    </div>
</div>
</br>
<div class="container">
  <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
          <thead class="thead-dark">
             <th class="text-center"  style="color: white">No. Orden</th>
             <th class="text-center"  style="color: white">Estado</th>
             <th class="text-center"  style="color: white">Fecha Creaci&oacute;n</th>
             <th class="text-center"  style="color: white">Acción</th>
          </thead>
          <tbody>
            @foreach ($ordenes as $orden)
            <tr>
                <td align="center">{{ $orden->id}}</td>
                <td align="center">
                @if( $orden->estado == "A") Activo @else Inactivo @endif
                </td>
                <td align="center">{{ $orden->fecha_creacion}}</td>
                <td class="w-150 text-center">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editarOrdenModal"
                    data-orden="{{$orden->id}}">
                        <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#eliminarOrdenModal" title="Eliminar Orden"
                    data-whatever="{{$orden->id}}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
          </tbody>
      </table>
  </div>
</div>

<!-- Modal Creacion -->
<div class="modal fade" id="crearOrdenModal" tabindex="-1" role="dialog" aria-labelledby="crearOrdenModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Orden</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <h6>Agregar Detalle Orden</h6>
            <table id="tablaDetallesNuevaOrden" class="table">
            <thead>
                <tr>
                    <td>Nombre producto</td>
                    <td>Cantidad</td>
                </tr>
            </thead>
            <tbody>
                <tr class='form-registro'>
                    <td class="col-md-5">
                        <input type="text" name="producto"  class="form-control producto" />
                    </td>
                    <td class="col-md-5">
                        <input type="number" name="cantidad"  class="form-control cantidad"/>
                    </td>
                        <td class="col-md-2"><a class="deleteRow"></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: left;">
                        <input type="button" class="btn btn-lg btn-block btn-primary " id="agregarDetalle" value="Agregar Detalle"/>
                    </td>
                </tr>
                <tr>
                </tr>
            </tfoot>
        </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarOrden">Cerrar</button>
        <button type="button" class="btn btn-success" id="guardarOrden">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarOrdenModal" tabindex="-1" role="dialog" aria-labelledby="editarOrdenModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Orden</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <h6>Editar Detalle Orden #</h6>
            <table id="tablaDetallesEditarOrden" class="table">
            <thead>
                <tr>
                    <td>Nombre producto</td>
                    <td>Cantidad</td>
                </tr>
            </thead>
            <tbody>
                <tr class='form-registro-edit'>
                    
                </tr>
            </tbody>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
        </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarEditarOrden">Cerrar</button>
        <button type="button" class="btn btn-success" id="editarOrden">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarOrdenModal" tabindex="-1" role="dialog" aria-labelledby="eliminarOrdenModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar orden #&nbsp;<span aria-hidden="true" id="eliminarOrdenModalLabel"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="">¿Está seguro que desea eliminar la orden # <span aria-hidden="true" id="numeroOrden"></span> ?</label>
        <input type="text" name="idOrdenEliminar" class="form-control" id="idOrdenEliminar" hidden/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarEliminarOrden">Cerrar</button>
        <button type="button" class="btn btn-danger" id="eliminarOrden">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    var contador = 0;

    $("#agregarDetalle").on("click", function () {
        var fila = $("<tr class='form-registro'>");
        var columna = "";

        columna += '<td><input type="text" class="form-control producto" name="producto' + contador + '"/></td>';
        columna += '<td><input type="number" class="form-control cantidad" name="cantidad' + contador + '"/></td>';
        columna += '<td><input type="button" class="btnEliminar btn btn-md btn-danger "  value="Eliminar"></td>';

        fila.append(columna);
        $("#tablaDetallesNuevaOrden").append(fila);
        contador++;
    });

    $("#tablaDetallesNuevaOrden").on("click", ".btnEliminar", function (event) {
        $(this).closest("tr").remove();
        contador -= 1
    });

    $("#tablaDetallesEditarOrden").on("click", ".btnEliminar", function (event) {
        $(this).closest("tr").remove();
        contador -= 1
    });
});

$('#eliminarOrdenModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var recipient = button.data('whatever');
  $('#eliminarOrdenModalLabel').text(recipient);
  $('#numeroOrden').text(recipient);
  $('#idOrdenEliminar').val(recipient);
});

$("#guardarOrden").on("click", function () {
    var registros = [];

    $('.form-registro').each(function () {
        var registro = new Object();
        registro.producto = $(this).find(".producto").val();
        registro.cantidad = $(this).find(".cantidad").val();
        registros.push(registro);
    });

    var json_registro = JSON.stringify(registros);

    $.ajax({
        type: "POST",
        url: "/guardarOrden",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $("#guardarOrden").prop("disabled", true);
            $("#cerrarOrden").prop("disabled", true);
        },
        data: {"form": json_registro},
        success: function (data) {
            if(data == "OK")
            {
                window.location.href = '/listaOrden';
            }
        },
        complete: function () {
            $("#guardarOrden").prop("disabled", false);
            $("#cerrarOrden").prop("disabled", false);
        }
    });
});

$('#editarOrdenModal').on('show.bs.modal', function (event) {
    var boton = $(event.relatedTarget);
    var idOrden = boton.data('orden');

    $.ajax({
        type: "GET",
        url: "/obtenerDetalleOrden",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $("#eliminarOrden").prop("disabled", true);
            $("#cerrarEliminarOrden").prop("disabled", true);
        },
        data: {"idOrden": idOrden},
        success: function (data) {
            var contador = 0;
            data.forEach(function(item){
                var fila = $("<tr class='form-registro-edit'>");
                var columna = "";

                columna += '<td><input type="text" class="form-control producto" name="producto' + contador + '" value="'+ item.descripcion_producto +'"/></td>';
                columna += '<td><input type="number" class="form-control cantidad" name="cantidad' + contador + '" value="'+ item.cantidad +'"/></td>';
                columna += '<td><input type="text" class="form-control idDetalle" name="idDetalle' + contador + '" value="'+ item.id +'" hidden/></td>';
                columna += '<td><input type="text" class="form-control idOrden" name="idOrden' + contador + '" value="'+ idOrden +'" hidden/></td>';
                columna += '<td><input type="button" class="btnEliminar btn btn-md btn-danger "  value="Eliminar"></td>';

                fila.append(columna);
                $("#tablaDetallesEditarOrden").append(fila);
                contador++;
            });
        },
        complete: function () {
            $("#eliminarOrden").prop("disabled", false);
            $("#cerrarEliminarOrden").prop("disabled", false);
        }
    });
});

$("#editarOrden").on("click", function () {
    var registros = [];

    $('.form-registro-edit').each(function () {
        var registro = new Object();
        registro.producto = $(this).find(".producto").val();
        registro.cantidad = $(this).find(".cantidad").val();
        registro.idDetalle = $(this).find(".idDetalle").val();
        registro.idOrden = $(this).find(".idOrden").val();
        registros.push(registro);
    });

    var json_registro = JSON.stringify(registros);

    $.ajax({
        type: "POST",
        url: "/editarOrden",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $("#editarOrden").prop("disabled", true);
            $("#cerrarEditarOrden").prop("disabled", true);
        },
        data: {"form": json_registro},
        success: function (data) {
            if(data == "OK")
            {
                window.location.href = '/listaOrden';
            }
        },
        complete: function () {
            $("#editarOrden").prop("disabled", false);
            $("#cerrarEditarOrden").prop("disabled", false);
        }
    });
});

$("#eliminarOrden").on("click", function () {
    var idOrden = $('#idOrdenEliminar').val();

    $.ajax({
        type: "POST",
        url: "/eliminarOrden",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $("#eliminarOrden").prop("disabled", true);
            $("#cerrarEliminarOrden").prop("disabled", true);
        },
        data: {"idOrden": idOrden},
        success: function (data) {
            if(data == "OK")
            {
                window.location.href = '/listaOrden';
            }
        },
        complete: function () {
            $("#eliminarOrden").prop("disabled", false);
            $("#cerrarEliminarOrden").prop("disabled", false);
        }
    });
});


</script>
@stop