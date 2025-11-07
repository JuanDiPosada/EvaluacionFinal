<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ORMController extends Controller
{
    public function testAllRelations(Request $request) 
    { 
        $models = [ 
            'cart' => [Cart::class, ['user','product','service']],
            'category' => [Category::class, ['company','products','services']],
            'company' => [Company::class, ['user','products','services','categories','orders']],
            'delivery' => [Delivery::class, ['user','vehicle']],
            'order' => [Order::class, ['user','company','product','service']],
            'product' => [Product::class, ['company','carts','orders','categories']],
            'role' => [Role::class, ['users']],
            'service' => [Service::class, ['company','category','orders','carts']],
            'user' => [User::class, ['delivery','roles','company','orders','carts']],
            'vehicle' => [Vehicle::class, ['delivery']],

        ]; 
 
        $results = []; 
 
        foreach ($models as $name => [$class, $relations]) { 
            if ($record = $class::first()) { 
                $record->load($relations); 
                $results[$name] = $record; 
            } 
        } 
 
        return response()->json([ 
            'success' => true, 
            'message' => 'Relaciones cargadas correctamente', 
            'total_models_tested' => count($results), 
            'models_found' => array_keys($results), 
            'data' => $results, 
        ]); 
    }
}
