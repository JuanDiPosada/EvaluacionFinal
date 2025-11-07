<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','description','company_id']; 
    protected $allowFilter=['id','name','description','company_id']; 
    protected $allowIncluded=['company','products','services'];
    public function company()  {
        return $this->belongsTo(Company::class);
    }
    public function products()  {
        return $this->hasMany(Product::class);
    }
    public function services()  {
        return $this->hasMany(Service::class);
    }
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request("included"))) {
            return;
        }

        $relations = explode(',', request('included'));

        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request("filter"))) {
            return;
        }

        $filters = request('filter');

        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {

            if ($allowFilter->contains($filter)) {
                $query->WHERE($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }
}
