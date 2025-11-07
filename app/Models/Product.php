<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['name','description','price','quantity','image','category_id','company_id']; 
    protected $allowFilter=['name','description','price','quantity','image','category_id','company_id']; 
    protected $allowIncluded=['company','carts','orders','categories'];
    public function company()  {
        return $this->belongsTo(Company::class);
    }
    public function carts()  {
        return $this->hasMany(Cart::class);
    }
    public function orders()  {
        return $this->hasMany(Order::class);
    }
    public function categories()  {
        return $this->belongsTo(Category::class);
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
