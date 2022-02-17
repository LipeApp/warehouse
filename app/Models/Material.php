<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
