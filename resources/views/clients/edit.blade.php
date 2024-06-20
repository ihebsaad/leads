@extends('layouts.app')
@section('styles')

  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css')}}">
<style>

</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Client {{$client->prenom}} {{$client->nom}} </h2>
            </div>
            <div class="float-right">
                <a class="btn btn-primary" href="{{ route('clients.index') }}"> Retour</a>
            </div>
        </div>
    </div>

    <form action="{{ route('clients.update',$client->id) }}" method="POST">
		@csrf
		@method('PUT')
        <div class="row pl-3">

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Nom:</strong>
                    <input type="text" name="nom" class="form-control" placeholder="Nom" value="{{ $client->nom }}" required>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Prénom:</strong>
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="{{ $client->prenom }}" required>
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Téléphone 1:</strong>
                    <input type="text" name="telephone_1" class="form-control" placeholder="Téléphone 1" value="{{ $client->telephone_1 }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Téléphone 2:</strong>
                    <input type="text" name="telephone_2" class="form-control" placeholder="Téléphone 2" value="{{ $client->telephone_2 }}">
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $client->email }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Mobile:</strong>
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ $client->mobile }}">
                </div>
            </div>
        </div>

        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Adresse:</strong>
                    <input type="text" name="adresse" class="form-control" placeholder="Adresse" value="{{ $client->adresse }}" />
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <input type="text" name="ville" class="form-control" placeholder="Ville" value="{{ $client->ville }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <input type="text" name="code_postal" class="form-control" placeholder="Code postal" value="{{ $client->code_postal }}">
                </div>
            </div>
        </div>

        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Observations Client:</strong>
                    <textarea name="observ_client" class="form-control" placeholder="Observations Client">{{$client->observ_client }}</textarea>
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Observations Responsable:</strong>
                    <textarea name="observ_responsable" class="form-control" placeholder="Observations Responsable">{{ $client->observ_responsable }}</textarea>
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Observations Commercial:</strong>
                    <textarea name="observ_commercial" class="form-control" placeholder="Observations Commercial">{{ $client->observ_commercial }}</textarea>
                </div>
            </div>
        </div>

        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <strong>ID avant transfert:</strong>
                    <input type="text" name="id_avant_transfert" class="form-control" placeholder="ID avant transfert" value="{{ $client->id_avant_transfert }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Statut 1:</strong>
                    <input type="text" name="obs_statut1" class="form-control" placeholder="Statut 1" value="{{ $client->obs_statut1 }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Statut 2:</strong>
                    <input type="text" name="obs_statut2" class="form-control" placeholder="Statut 2" value="{{ $client->obs_statut2 }}">
                </div>
            </div>
        </div>

        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Historique des statuts:</strong>
                    <textarea name="historique_statuts" class="form-control" placeholder="Historique des statuts">{{ $client->historique_statuts }}</textarea>
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <strong>Date du lead:</strong>
                    <input type="text" name="date_du_lead" class="form-control" placeholder="Date du lead" value="{{ $client->date_du_lead }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Surface habitable:</strong>
                    <input type="text" name="surface_habitable" class="form-control" placeholder="Surface habitable" value="{{ $client->surface_habitable }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Superficie habitable:</strong>
                    <input type="text" name="superficie_habitable" class="form-control" placeholder="Superficie habitable" value="{{ $client->superficie_habitable }}">
                </div>
            </div>
        </div>

        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <strong>Propriétaire / Locataire:</strong>
                    <select name="proprietaire_locataire" class="form-control">
                        <option @if($client->proprietaire_locataire=="Propriétaire") selected="selected" @endif value="Propriétaire"  >Propriétaire</option>
                        <option @if($client->proprietaire_locataire=="Locataire") selected="selected" @endif  value="Locataire"  >Locataire</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Chauffage:</strong>
                    <input type="text" name="chauffage" class="form-control" placeholder="Chauffage" value="{{ $client->chauffage }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <strong>Temps passé (min):</strong>
                    <input type="text" name="temps_passe_min" class="form-control" placeholder="Temps passé (min)" value="{{ $client->temps_passe_min }}">
                </div>
            </div>
        </div>
        <div class="row pl-3 mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12 pt-2">
                <button type="submit" class="btn btn-primary float-right">Enregistrer</button>
            </div>
        </div>
	</form>

@endsection


@section('footer-scripts')
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}" ></script>

<script>


  $(function () {
    // Summernote
    $('.summernote').summernote()
  });

</script>

@endsection

