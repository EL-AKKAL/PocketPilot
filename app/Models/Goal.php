<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['value', 'period', 'status', 'starts_at', 'ends_at'])]
class Goal extends Model {}
