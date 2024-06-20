<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ClientsImport implements ToModel, WithHeadingRow, WithChunkReading, WithCustomCsvSettings
{
    protected $delimiter;

    public function __construct($delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => $this->delimiter
        ];
    }

    public function model(array $row)
    {
        return Client::updateOrCreate(
            ['id' => $row['id']], // Condition pour vérifier si le client existe déjà
            [
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
            'added_by'=>auth()->user()->id
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}