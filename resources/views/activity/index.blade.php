@extends('layouts.app')

@section('styles')

  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Historique des activités</h2>
            </div>
            <div class="float-right mb-3"  >

            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered" id="mytable" style="width:100%">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Action</th>
                <!--<th style="max-width:400px">Détails</th>-->
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->causer->name ?? 'Système' }}</td>
                <td>{{ $activity->description }}</td>
                <!--<td style="max-width:400px">{{ $activity->properties }}</td>-->
                <td>{{ $activity->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
@section('footer-scripts')

<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#mytable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      order: [[ 0, 'desc' ]],
      buttons: [
                    {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>  Imprimer',
                    exportOptions: {
                 //   columns: [  1,2,3,4,5,6  ],
                	}
                    },
                    {
                    extend: 'csv',
                    text: '<i class="fa fa-file-csv"></i>  Csv',
                    exportOptions: {
                //    columns: [ 1,2,3,4,5,6]
                	}
                    },
				 {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i>  Excel',
                    exportOptions: {
                 //   columns: [ 1,2,3,4,5,6]
               	}
                    },
				{
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf"></i>  Pdf',
                    exportOptions: {
                //    columns: [  1,2,3,4,5,6 ]
                	}
                    }

                ]   ,   "language": {
					"decimal":        "",
					"emptyTable":     "Pas de données",
					"info":           "Affichage de  _START_ à _END_ de _TOTAL_ entrées",
					"infoEmpty":      "Affichage 0 à 0 of 0 entries",
					"infoFiltered":   "(filteré de _MAX_ total entrées)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "afficher _MENU_ ",
					"loadingRecords": "Chargement...",
					"processing":     "Chargement...",
					"search":         "Recherche:",
					"zeroRecords":    "Pas de résultats",
						"paginate": {
						"first":      "Premier",
						"last":       "Dernier",
						"next":       "Suivant",
						"previous":   "Premier"
									},
						"aria": {
						"sortAscending":  ": Activer pour un Tri ascendant",
						"sortDescending": ": Activer pour un Tri descendant"
								}
					},
                    "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                        } ],
    }).buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');


  });
</script>

@endsection
