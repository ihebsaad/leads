<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->user_type == 'admin')
            $clients = Client::orderBy('id','desc')->get();
        else
            $clients = Client::where('added_by',auth()->user()->id)->orderBy('id','desc')->get();

            $columns = [
                'id', 'prenom', 'nom', 'mobile', 'telephone_1', 'telephone_2', 'email', 'adresse', 'ville','code_postal',
                'date_de_creation', 'date_de_modification', 'proprietaire_locataire','observ_client','observ_responsable','observ_commercial','superficie_habitable',
                'surface_habitable', 'temps_passe_min', 'chauffage', 'civilite', 'maison_appartement','obs_statut1','obs_statut2','date_du_lead','flags','id_avant_transfert','historique_statuts'
            ];

         return view('clients.index',compact('clients','columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required'
        ]);

        $client=Client::create($request->all());

        activity('client')
            ->performedOn($client)
            ->causedBy(auth()->user())
            ->log('created');

        return redirect()->route('clients.index')->with('success','Client créé avec succès.');

    }


    public function store_api(Request $request)
    {
        $request->validate([
            'last_name' => 'required'
        ]);

/*
        sender
last_name
Le champ sender doit contenir le login d'un utilisateur valide du CRM.
Voici quelques uns des champs principaux que l'on peut envoyer:
id (si id est fourni, le lead sera mis à jour au lieu d'être créé)
first_name
address
zip
city
email
mobile
phone1*/
/*
'prenom' => $row['prenom'],
'nom' => $row['nom'],
'adresse' => $row['adresse'],
'mobile' => $row['mobile'],
'telephone_1' => $row['telephone_1'],
'telephone_2' => $row['telephone_2'],
'email' => $row['email'],
'code_postal' => $row['code_postal'],
'ville' => $row['ville'],
'date_de_creation' => $row['date_de_creation'],
'date_de_modification' => $row['date_de_modification'],
'date_du_lead' => $row['date_du_lead'],
'proprietaire_locataire' => $row['proprietaire_locataire'],
'surface_habitable' => $row['surface_habitable'],
'superficie_habitable' => $row['superficie_habitable'],
'temps_passe_min' => $row['temps_passe_min'],
'chauffage' => $row['chauffage'],
'civilite' => $row['civilite'],
'maison_appartement' => $row['maison_appartement'],
'observ_client' => $row['observ_client'],
'observ_responsable' => $row['observ_responsable'],
'observ_commercial' => $row['observ_commercial'],
'id_avant_transfert' => $row['id_avant_transfert'],
'obs_statut1' => $row['obs_statut1'],
'obs_statut2' => $row['obs_statut2'],
'historique_statuts' => $row['historique_statuts'],
'flags' => $row['flags'],
*/

        $clientData = [
            'nom' => $request['last_name'],
            'prenom' => $request['first_name'] ?? '',
            'email' => $request['email'] ?? '',
            'telephone_1' => $request['phone1'] ?? '',
            'telephone_2' => $request['phone2'] ?? '',
            'mobile' => $request['mobile'] ?? '',
            'code_postal' => $request['zip'] ?? '',
            'adresse' => $request['address'] ?? '',
            'added_by' => $request['added_by'] ?? -1,

            'ville' => $request['ville'] ?? '',
            'date_de_creation' => $request['date_de_creation'],
            'date_de_modification' => $request['date_de_modification'],
            'date_du_lead' => $request['date_du_lead'],
            'proprietaire_locataire' => $request['proprietaire_locataire'] ?? '',
            'surface_habitable' => $request['surface_habitable'] ?? '',
            'superficie_habitable' => $request['superficie_habitable'] ?? '',
            'temps_passe_min' => $request['temps_passe_min'] ?? 0,
            'chauffage' => $request['chauffage'] ?? '',
            'civilite' => $request['civilite'] ?? '',
            'maison_appartement' => $request['maison_appartement'] ?? '',
            'observ_client' => $request['observ_client'] ?? '',
            'observ_responsable' => $request['observ_responsable'] ?? '',
            'observ_commercial' => $request['observ_commercial'] ?? '',
            'obs_statut1' => $request['obs_statut1'] ?? '',
            'obs_statut2' => $request['obs_statut2'] ?? '',
            'historique_statuts' => $request['historique_statuts'] ?? '',
            'flags' => $request['flags'] ?? '',
        ];


        //$client=Client::create($request->all());
        $client=Client::create($clientData);

        return response()->json(['success' => true, 'client' => $client]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('clients.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom' => 'required',
        ]);
        if (auth()->user()->user_type == 'admin' || $client->commercial== auth()->user()->id )
            $client->update($request->all());

            activity('client')
            ->performedOn($client)
            ->causedBy(auth()->user())
            ->log('updated');

        return redirect()->route('clients.index')
                        ->with('success','Client modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (auth()->user()->user_type == 'admin' || $client->commercial== auth()->user()->id )
            $client->delete();

            activity('client')
            ->performedOn($client)
            ->causedBy(auth()->user())
            ->log('deleted');

        return redirect()->route('clients.index')
                        ->with('success','Client supprimé avec succès');
    }


    public function restore($id)
    {
        $version = Client::findVersion($id);
        $version->restore();
        activity('client')
            ->performedOn($version)
            ->causedBy(auth()->user())
            ->log('restored');

        return redirect()->route('clients.index');
    }


    public function export(Request $request)
    {
        $columns = $request->input('columns', []);
        $format = $request->input('format', 'xlsx');

        if (empty($columns)) {
            return back()->withErrors('Sélectionnez une colonne au moins.');
        }
        $date=date('d-m-Y H_i');

        activity('client')
        ->causedBy(auth()->user())
        ->log('Export des clients');

        return Excel::download(new ClientsExport($columns), 'clients_'.$date.'.' . $format);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'separator' => 'required|string',
        ]);

        $separator = $request->input('separator');
        Excel::import(new ClientsImport($separator), $request->file('file'));
        activity('client')
        ->causedBy(auth()->user())
        ->log('Import des clients');

        return  redirect()->route('clients.index')
                ->with('success', 'Clients importés.');
    }
}