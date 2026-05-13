<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string title
 * @property string description
 */
class Ambient
	extends Model
{
	use HasUuids, HasFactory;

	protected $table = 'ambient';
}
