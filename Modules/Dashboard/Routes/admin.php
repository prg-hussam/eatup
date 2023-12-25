<?php

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Meal\Entities\DiningPeriod;
use Modules\Meal\Entities\Meal;

Route::get('/', 'DashboardController@index')->name('dashboard.index');
Route::get('/test', function () {



    $dining = 5; // Lunch

    $diningPeriod = DiningPeriod::where('id', $dining)->first();
    $categories = $diningPeriod->categories;

    $categoryId = 1; // Main Course


    $meals = Meal::where('category_id', $categoryId)->whereHas('diningPeriods', function ($query) use ($dining) {
        $query->where('dining_period_id', $dining);
    })->get();

    dd($meals);
    /**
     * 
     * type =  weight
     * unit =  gram
     * 
     * min =  250
     * max =  500
     * 
     * 
     * protein = PG * W
     * 
     * 
     * 
     * protein_per_gram = 10
     * carbs_per_gram = 10
     * fat_per_gram = 10
     * sugars_per_gram = 10
     * 
     * calories = (P+C+F+S) * min = 10000
     * 
     * 
     * 250 
     *  251
     */


    // $weight = 251;
    // $protein_calories_per_gram = 2;
    // $carbs_calories_per_gram = 2;
    // $fat_calories_per_gram = 2;
    // $sugars_calories_per_gram = 2;

    // $calories = (
    //     $protein_calories_per_gram
    //     + $carbs_calories_per_gram +
    //     $fat_calories_per_gram +
    //     $sugars_calories_per_gram
    // ) * $weight;

    // echo "calories = $calories <br />";
    // echo "protein_calories_per_gram: " . $protein_calories_per_gram * $weight . "<br />";
    // echo "carbs_calories_per_gram: " . $carbs_calories_per_gram * $weight . "<br />";
    // echo "fat_calories_per_gram: " . $fat_calories_per_gram * $weight . "<br />";
    // echo "sugars_calories_per_gram: " . $sugars_calories_per_gram * $weight . "<br />";
});