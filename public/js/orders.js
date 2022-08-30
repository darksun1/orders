var token=$('meta[name="csrf-token"]').attr('content');
$(document).ready(()=>{
    renderTable();
});
function renderTable(){
    $('#table-orders').DataTable({
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            'url': '/render-table',
            'type': 'GET',
        },
        columns: [
            {data:'number',orderable:true,searchable:true},
            {data:'desc_status',searchable:true},
            {data:'date',searchable:true},
            {data:'total',searchable:false},
            {data:'total_weight',searchable:false},
            {data:'size',searchable:false},
            {data:'products',searchable:true},
            {data:'address',searchable:true},
            {data:'actions',orderable:false,searchable:false}
        ],
        columnDefs: [
            {
                targets: 1,
                data: null,
                render: (data,type,row,meta)=>{
                    cad='';
                    if(row.status==5){
                        cad+=row.desc_status+'<br>Reembolso: ';
                        if(row.refund==0)
                            cad+='<b>No</b>';
                        else
                            cad+='<b>Si</b>';
                    }
                    else
                        cad=row.desc_status;
                    return cad;
                }
            },
            {
                targets: 6,
                data: null,
                render: (data,type,row,meta)=>{
                    cad='';
                    for(i=0;i<row.products.length;i++){
                        cad+=row.products[i].quantity+' - '+row.products[i].product+'<br>';
                    }
                    return cad;
                }
            },
            {
                targets: -1,
                data: null,
                render: (data,type,row,meta)=>{
                    cad='';
                    if(row.status==0)
                        cad+='<a role="button" class="btn btn-info btn-sm" style="margin-left:10px" href="javascript:void(0)" onclick="changeStatus('+row.id+',1)">Recolectada</a>';
                    if(row.status==1)
                        cad+='<a role="button" class="btn btn-info btn-sm" style="margin-left:10px" href="javascript:void(0)" onclick="changeStatus('+row.id+',2)">En estación</a>';
                    if(row.status==2)
                        cad+='<a role="button" class="btn btn-info btn-sm" style="margin-left:10px" href="javascript:void(0)" onclick="changeStatus('+row.id+',3)">En ruta</a>';
                    if(row.status==3)
                        cad+='<a role="button" class="btn btn-success btn-sm" style="margin-left:10px" href="javascript:void(0)" onclick="changeStatus('+row.id+',4)">Entregada</a>';
                    if(row.status==0 || row.status==1 || row.status==2)
                        cad+='<a role="button" class="btn btn-danger btn-sm" style="margin-left:10px;margin-top:5px" href="javascript:void(0)" onclick="changeStatus('+row.id+',5)">Cancelada</a>';
                    return cad;
                }
            }
        ]
    });
}
function changeStatus(order,n){
    bootbox.confirm({
        message: "¿Está seguro de cambiar el estatus de la orden?",
        buttons: {
            confirm: {
                label: 'Si',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
                $.ajax({
                    url:'/change-status',
                    type:'POST',
                    data:{_token:token,status:n,id:order},
                    success:(data)=>{
                        if(data>0){
                            bootbox.alert('Se cambió el estatus correctamente.');
                            $('#table-orders').hide();
                            $('#table-orders').DataTable().destroy();
                            setTimeout(()=>{
                                $('#table-orders').show();
                                renderTable();
                            },400);
                        }
                        else
                            bootbox.alert('Ocurrió un error.');
                    }
                });
            }
        }
    });
}
function uploadcsv(){
    
}