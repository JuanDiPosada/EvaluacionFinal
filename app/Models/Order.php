<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['date','name_customer','address','phone','status','quantity','product_id','service_id','company_id','user_id']; 
    protected $allowFilter=['id','date','name_customer','address','phone','status','quantity','product_id','service_id','company_id','user_id']; 
    protected $allowIncluded=['user','company','product','service'];
    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function company()  {
        return $this->belongsTo(Company::class);
    }
    public function product()  {
        return $this->belongsTo(Product::class);
    }
    public function service()  {
        return $this->belongsTo(Service::class);
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
