<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Mpociot\Versionable\VersionableTrait;
use Spatie\Activitylog\LogOptions;

class Client extends Model
{
    use HasFactory,
    LogsActivity, VersionableTrait;

    protected $table = "clients";

    protected $guarded = [];
/*
	protected $fillable = [
 
    ];
*/

    protected static $logAttributes = ['name', 'email', 'phone'];
    protected static $logName = 'client';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Client has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('client')
            ->logOnlyDirty();
    }

}
