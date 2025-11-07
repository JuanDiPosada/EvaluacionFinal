<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{   
    protected $fillable=['gender','birth_date','vehicle_type','transt_license','user_id']; 
    protected $allowFilter=['id','gender','birth_date','vehicle_type','transt_license','user_id']; 
    protected $allowIncluded=['user','vehicle'];
    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function vehicle()  {
        return $this->hasOne(Vehicle::class);
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
