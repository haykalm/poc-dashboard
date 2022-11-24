<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleTapMenu extends Model
{
	use HasFactory;

	protected $table = 'people_tap_menu';

	protected $fillable = [
		'nik',
		'absen_a_time_in',
		'absen_b_time_in',
		'absen_c_time_in',
		'status_tap_in',
		'absen_a_time_out',
		'absen_b_time_out',
		'absen_c_time_out',
		'status_tap_out',
	];

}
