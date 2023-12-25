<?php

namespace Modules\User\Entities;

use App\Platform;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Modules\Meal\Entities\Ingredient;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Meal\Entities\Meal;

use function PHPUnit\Framework\isNull;

class Customer extends Authenticatable
{

    //TODO:: add soft delete
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'birth_date',
        'daily_calories',
        'gender',
        'weight',
        'height',
        'is_profile_completed',
        'avatar',
        'is_active',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_profile_completed' => 'boolean',
        'is_active' => 'boolean',
    ];




    /**
     * The ingredients that belong to the customer.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }


    public function getGenderText()
    {
        //TODO:: trans 
        return is_null($this->gender) ? null : ($this->gender == 1 ? 'Male' : 'Female');
    }

    /**
     * Check if the provided meal data contains any ingredients marked as unfavorite by the customer.
     *
     * @param array $mealIngredients The ingredients of the meal to check for unfavorite ingredients.
     * @return array 
     */
    public function unfavourableIngredients(array $mealIngredients): array
    {
        $unfavoriteIngredients = $this->ingredients->pluck('id')->toArray();

        // Find common elements (intersection) between the meal's ingredients and customer's unfavorite ingredients
        $commonIngredients = array_intersect($unfavoriteIngredients, $mealIngredients);
        $getIngredientNames = $this->ingredients->whereIn('id', $commonIngredients)->pluck('name')->toArray();

        return [
            'have_unfavourite_ingredients' => count($commonIngredients) > 0,
            'unfavourite_ingredient_names' => $getIngredientNames
        ];
    }



    /**
     * Get phone number
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($phone) => phone($phone, setting('default_country'))->formatNational(),
            set: fn ($phone) => phone($phone, setting('default_country'))->formatE164(),
        );
    }
}