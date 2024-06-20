<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer')->orderBy('id','desc')->get();
        return view('activity.index', compact('activities'));
    }

    public function restore($id)
    {
        $activity = Activity::findOrFail($id);
        $client = $activity->subject; // Récupère le modèle Client associé à l'activité

        // Restaure la version associée à l'activité
        $version = $client->versions()->find($activity->properties['version_id']);
        $version->rollback();

        return redirect()->route('activities.index')->with('success', 'Version restaurée avec succès');
    }
}
