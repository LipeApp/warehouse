<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['material_id', 'reminder'];

    protected $searchableFields = ['*'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
