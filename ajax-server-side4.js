"use strict";
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		
		var table = $('#kt_table_1');
		
		// begin first table
		table.DataTable({
			responsive: true,
			searchHighlight: true,		
			
        dom: 'Bfrtpli',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],					
			
  language: {
	"sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando reg. del _START_ al _END_ de un total de _TOTAL_ reg.",
	"sInfoEmpty":      "Mostrando reg. del 0 al 0 de un total de 0 reg.",
	"sInfoFiltered":   "(filtrado de un total de _MAX_ reg.)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Prim.",
		"sLast":     "Últ.",
		"sNext":     "Sig.",
		"sPrevious": "Ant."
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
  },			
			
			searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: 'server3.php',
			columns: [
				{data: 'id'},
				{data: 'especie'},
				{data: 'familia'},
				{data: 'nombre_comun'},
				{data: 'proyecto'},
				{data: 'base_del_registro'},
				{data: 'identificador'},
				{data: 'ano_identificacion'},
				{data: 'departamento'},
				{data: 'municipio'},
				{data: 'localidad'},
				{data: 'latitud'},
				{data: 'longitud'},
				{data: 'autor'},
				{data: 'fecha_captura'},
				{data: 'ecorregion'},
				{data: 'id', responsivePriority: -1}
			],
			order: [[ 0, "desc" ]],
						
/*					
"columnDefs":[{"targets":2, "data":"name", "render": function(data,type,full,meta)
 { return '<a href=view.html?id='+data+'><img src="<%= request.getContextPath()%>/resources/images/view.png"'+
'style="border:0;" title="View" '+
'alt="View" /></a> &nbsp&nbsp'+
 '<a href=view.html?id='+data+'><img src="<%= request.getContextPath() %>/resources/images/edit.png"'+
'style="border:0;" title="Edit" '
}}]	*/			
			
			columnDefs: [
			
  				{
      				targets: 0, // your case first column
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 1,
      				className: "text-center",
      				width: "5%"
 				},
				
				
				{
      				targets: 2,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 3,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 4,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 5,
      				className: "text-center",
      				width: "5%"
 				},
				
								{
      				targets: 6,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 7,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 8,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 9,
      				className: "text-center",
      				width: "5%"
 				},
			
				{
      				targets: 10,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 11,
      				className: "text-center",
      				width: "5%"
 				},
			
				{
      				targets: 12,
      				className: "text-center",
      				width: "5%"
 				},
				
				{
      				targets: 13,
      				className: "text-center",
      				width: "5%"
 				},				
								
				
				{
      				targets: 14,
      				//visible: false
					className: "text-center",
      				width: "5%"

 				},
				
				{
      				targets: 15,
      				//visible: false
					className: "text-center",
      				width: "5%"

 				},
				
				
				{
      				targets: 16,
					className: "text-center",
      				width: "5%",
					title: 'Accion',
					orderable: false,
					render: function(data, type, row) {						

					return '<a href="#edit_modal_'+ data +'" class="btn btn-sm btn-clean btn-icon btn-icon-md openBtn" data-toggle="modal" title="Editar Especie No. '+ data +'"><i class="la la-pencil"></i></a><a href="#delete_modal_'+ data +'" class="btn btn-sm btn-clean btn-icon btn-icon-md openBtn" data-toggle="modal" title="Borrar Especie No. '+ data +'"><i class="la la-remove"></i></a><!-- Delete Modal --><div class="modal fade" id="delete_modal_'+ data +'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><center><h4 class="modal-title" id="myModalLabel">Borrar Especie No. '+ data +'</h4></center><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button></div><div class="modal-body"><p class="text-center">Esta seguro que desea borrar la especie No. '+ data +'?</p><h2 class="text-center"></h2></div><div class="modal-footer"><button type="button" class="btn btn-default la la-times" data-dismiss="modal">&nbsp;Cancelar</button><a href="borrar.php?id='+ row.id +'" class="btn btn-danger"><span class="la la-trash"></span>&nbsp;Borrar</a></div></div></div></div><!-- Edit Modal --><div class="modal fade" id="edit_modal_'+ data +'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><center><h4 class="modal-title" id="myModalLabel">Editar Especie No. '+ row.id +'</h4></center><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button></div><div class="modal-body"><div class="container-fluid"><iframe src="editar.php?id='+ row.id +'" width="100%" height="520"></iframe></div></div></div></div></div>';
					
					}
 				}

			],
		});
	};
	

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});