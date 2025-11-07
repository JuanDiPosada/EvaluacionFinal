<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable=['company_name','nit','person_type','bank_name','account_number','account_type','user_id']; 
    protected $allowFilter=['id','company_name','nit','person_type','bank_name','account_number','account_type','user_id']; 
    protected $allowIncluded=['user','products','services','categories','orders'];    
    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function products()  {
        return $this->hasMany(Product::class);
    }
    public function services()  {
        return $this->hasMany(Service::class);
    }
    public function categories()  {
        return $this->hasMany(Category::class);
    }
    public function orders()  {
        return $this->hasMany(Order::class);
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
