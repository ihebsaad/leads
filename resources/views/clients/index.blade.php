@extends('layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}" />


@endsection
<style>
    .form-check {
        position: relative;
        display: inline-block!important;
        padding-left: 1.25rem;
        padding-right: 35px;
        min-width: 250px!important;
    }
    #export,#import{
        display:none;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Liste des clients</h2>
            </div>
            <div class="float-right mb-3"  >
                <a class="btn btn-success" href="{{ route('clients.create') }}"><i class="fas fa-plus"></i> Ajouter un client</a>
            </div>
            <div class="float-right mb-3 mr-3"  >
                <a class="btn btn-secondary" href="javascript:void(0)" onclick="$('#export').toggle('slow');"><i class="fas fa-download"></i> Export</a>
            </div>
            <div class="float-right mb-3 mr-3"  >
                <a class="btn btn-secondary" href="javascript:void(0)" onclick="$('#import').toggle('slow');"><i class="fas fa-upload"></i> Import</a>
            </div>
        </div>
    </div>

    <div class="row" id="import">
        <div class="col-md-12 margin-tb">

            <form  action="{{ route('clients.import') }}" class="dropzone"   id="dropzoneFrom">
                {{ csrf_field() }}
                <input type="hidden" name="user"  value="<?php echo auth()->user()->id; ?>">
                <input type="hidden" name="separator" id="separator"  value=",">
            </form>

<!--
            <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="separator">Séparateur:</label>
                    <select name="separator" id="separator1" class="form-control" onchange="$('#separator').val($('#separator1').val())">
                        <option value=",">Virgule (,)</option>
                        <option value=";">Point-virgule (;)</option>
                        <option value="\t">Tabulation (Tab)</option>
                        <option value="|">Barre verticale (|)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="file">Fichier CSV:</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Importer</button>
            </form>
-->
        </div>
        <div class="col-md-3 mb-5">
            <label for="separator">Séparateur:</label>
            <select name="separator" id="separator1" class="form-control" onchange="$('#separator').val($('#separator1').val())">
                <option value=",">Virgule (,)</option>
                <option value=";">Point-virgule (;)</option>
                <option value="\t">Tabulation (Tab)</option>
                <option value="|">Barre verticale (|)</option>
            </select>
        </div>
    </div>

    <div class="row">
        <form action="{{ route('clients.export') }}" method="POST">
            @csrf

            <div class="col-lg-12 margin-tb" id="export">
                <div class="form-group">
                    <label>Choisissez les champs à exporter :</label><br>
                        @foreach($columns as $column)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="columns[]" value="{{ $column }}" id="column_{{ $column }}">
                                <label class="form-check-label" for="column_{{ $column }}">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                            </div>
                        @endforeach
                </div>
                <table class=" float-right">
                    <tr>
                        <td>
                            <div >
                                <label>Format:</label>
                                <select name="format" id="format" class="form-control">
                                    <option value="xlsx">Excel (XLSX)</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </td>
                        <td class="pt-4">
                            <button type="submit" style="margin-top:6px" class="btn btn-primary float-right  ml-4 "><i class="fas fa-file-excel"></i>  Exporter</button>
                        <td>
                    </tr>
                </table>
            </div>
        </form>

    </div>
   <style>
		.small-img{width:150px;}
   </style>
    <table class="table table-bordered table-striped" id='mytable'>
        <thead>
            <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Tél</th>
            <th>Adresse </th>
            <th>Produits </th>
            <th>Statut </th>
            <th>Historique</th>
            <th>Observations</th>
            <th>Modifié</th>
            <th>Type</th>
            <th>Dates</th>
            <th class="no-sort" >Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
		<tr>
            <td>{!! sprintf('%04d',$client->id) !!}</td>
            <td>{{$client->prenom ?? ''}} {{$client->nom ?? ''}}</td>
            <td>{{ $client->telephone_1 ?? ''}}</td>
            <td>{{ $client->addresse ?? ''}} - {{ $client->ville ?? '' }} </td>
            <td>{{ $client->produits}} </td>
            <td>{{ $client->statut}} </td>
            <td>{{ $client->historique_statuts}} </td>
            <td>{{ $client->observ_responsable }} {{ $client->observ_commercial }} {{ $client->obs_statut1 }} {{ $client->obs_statut2 }} </td>
            <td>{{ $client->updated_at}} <?php if( $client->modified_by ) { $modif= \App\Models\User::find($client->modified_by); echo $modif->name;}else{
                if($client->added_by>0){$modif= \App\Models\User::find($client->added_by); echo '<br>'.$modif->name;}
            }?></td>
            <td>{{ $client->type}}</td>
            <td>{{ $client->Dates}}</td>
            <td>
			    <a class="btn btn-primary mb-3" href="{{ route('clients.edit',$client->id) }}" style="float:left" title="Modifier"><i class="fas fa-edit"></i></a>
                <form action="{{ route('clients.destroy',$client->id) }}" method="POST"   style="float:left" class="mr-2 ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mb-3" title="Supprimer" onclick="return ConfirmDelete();"><i class="fas fa-trash"></i> </button>
                </form>
            </td>
        </tr>
        </tbody>
        @endforeach
    </table>


@endsection
@section('footer-scripts')
<script src="{{ asset('js/dropzone.js') }}" ></script>
<script>
  Dropzone.options.dropzoneFrom = {
 // autoProcessQueue: false,
  acceptedFiles:".csv,.txt",
  dictDefaultMessage: 'Glissez votre fichier ici',

    init: function(){
   this.on("complete", function(){
        location.reload();
    });
  },
 };
 </script>

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
                    columns: [ 1,2,3,4,5,6]
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
