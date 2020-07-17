"use strict";
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: 'components/datatables/demos/server3.php',
			columns: [
				{data: 'rsv'},
				{data: 'codigo_producto'},
				{data: 'nombre_producto'},
				{data: 'check_in'},
				{data: 'check_out'},
				{data: 'nombre_cliente'},
				{data: 'email'},
				{data: 'estado'},
				{data: 'rsv', responsivePriority: -1},
			],
			
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
					targets: -1,
					title: 'Acciones',
					orderable: false,
					render: function(data, type, full, meta) {
					return '<span class="dropdown"><a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true"><i class="la la-ellipsis-h"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="la la-send"></i> Enviar Prereserva No. '+ data +'</a><a class="dropdown-item" href="#"><i class="la la-remove"></i> Cancelar Prereserva No. '+ data +'</a><a class="dropdown-item" href="#"><i class="la la-key"></i> Confirmar Reserva No. '+ data +'</a><a class="dropdown-item" href="#"><i class="la la-times-circle"></i> Cancelar Reserva No. '+ data +'</a></div></span><a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md openBtn" data-toggle="modal" data-target="#kt_modal_4" title="Editar Reserva No. '+ data +'"><i class="la la-edit"></i></a>';
					},		
					
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							/*
							1: {'title': 'Pending', 'class': 'kt-badge--brand'},
							2: {'title': 'Delivered', 'class': ' kt-badge--danger'},
							3: {'title': 'Canceled', 'class': ' kt-badge--primary'},
							4: {'title': 'Success', 'class': ' kt-badge--success'},
							5: {'title': 'Info', 'class': ' kt-badge--info'},
							6: {'title': 'Danger', 'class': ' kt-badge--danger'},
							7: {'title': 'Warning', 'class': ' kt-badge--warning'},
							*/
							espera: {'title': 'Prereserva', 'class': 'kt-badge--warning'},
							confirmada: {'title': 'Reserva', 'class': ' kt-badge--success'},
							muerta: {'title': 'Cancelada', 'class': ' kt-badge--danger'},							
							
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
					},
				},
				/*
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							muerta: {'title': 'muerta', 'state': 'danger'},
							espera: {'title': 'espera', 'state': 'primary'},
							confirmada: {'title': 'confirmada', 'state': 'success'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
							'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
					},	
				},
				*/
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