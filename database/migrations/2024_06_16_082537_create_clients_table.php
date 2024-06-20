<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('maison_appartement')->nullable(); // Maison / Appartement
            $table->string('prenom')->nullable(); // Prénom
            $table->string('nom')->nullable(); // Nom
            $table->string('telephone_1')->nullable(); // Téléphone 1
            $table->string('telephone_2')->nullable(); // Téléphone 2
            $table->text('observ_client')->nullable(); // Observ. client
            $table->text('observ_responsable')->nullable(); // Observ. responsable
            $table->text('observ_commercial')->nullable(); // Observ. commercial
            $table->string('adresse')->nullable(); // Adresse
            $table->string('code_postal')->nullable(); // Code postal
            $table->string('ville')->nullable(); // Ville
            $table->string('email')->nullable(); // E-mail
            $table->string('mobile')->nullable(); // Mobile
            $table->string('proprietaire_locataire')->nullable(); // Propriétaire / Locataire
            $table->string('civilite')->nullable(); // Civilité
            $table->string('chauffage')->nullable(); // Chauffage
            $table->date('date_de_creation')->nullable(); // Date de création
            $table->date('date_de_modification')->nullable(); // Date de modification
            $table->string('id_avant_transfert')->nullable(); // ID avant transfert
            $table->string('obs_statut1')->nullable(); // Obs. statut1
            $table->string('obs_statut2')->nullable(); // Obs. statut2
            $table->text('historique_statuts')->nullable(); // Historique des statuts
            $table->string('date_du_lead')->nullable(); // Date du lead
            $table->string('surface_habitable')->nullable(); // Surface habitable
            $table->string('flags')->nullable(); // Flags
            $table->string('superficie_habitable')->nullable(); // Superficie habitable
            $table->integer('temps_passe_min')->nullable(); // Temps passé (min)

            $table->integer('added_by')->nullable(); // user_id

            $table->string('type')->nullable();
            $table->string('statut')->nullable();
            $table->string('produits')->nullable();
            //$table->string('leads')->nullable();
            $table->text('dates')->nullable();
            $table->integer('modified_by')->nullable(); // user_id


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
