<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryInOut extends Model
{
    use HasFactory;

    protected $table = 'history_in_out';

	protected $fillable = [
		'id_people_tap_menu',
		'time_in',
		'time_out',
		'duration',
		'type_room',
	];
}
