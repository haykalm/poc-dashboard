<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTap extends Model
{
    use HasFactory;
    
    protected $table = 'detail_tap';

	protected $fillable = [
		'id_people_tap_menu',
		'time_out',
		'time_in',
		'type_room',
	];

	public function people_tap_menu()
    {
        return $this->hasOne(PeopleTapMenu::class,'id','id_people_tap_menu');
    }
}
