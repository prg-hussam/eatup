<?php

namespace Modules\Meal\Entities;

use App\Platform;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Modules\Category\Entities\Category;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model
{
    use Translatable, HasMedia, SoftDeletes;


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'category_id',
        'type',
        'unit',
        'calories',
        'min_qty',
        'max_qty',
        'protein_calories_per_unit',
        'carbs_calories_per_unit',
        'fat_calories_per_unit',
        'sugars_calories_per_unit',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ["thumbnail"];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function (Meal $meal) {
            if (Platform::inAdminPanel() && !empty(request()->all())) {

                $meal->saveRelations(request()->all());
            }
        });

        static::saving(function (Meal $meal) {
            if (Platform::inAdminPanel() && !empty(request()->all())) {
                $meal->calories = $meal->calcCalories();
            }
        });

        static::addActiveGlobalScope();
    }

    /**
     * 
     * 
     */
    private function calcCalories()
    {
        return $this->protein_calories_per_unit + $this->carbs_calories_per_unit + $this->fat_calories_per_unit + $this->sugars_calories_per_unit;
    }

    public function getTypeText()
    {
        return __("enums.{$this->type}");
    }
    /**
     * Save associated relations for the meal.
     *
     * @param array $attributes
     * @return void
     */
    public function saveRelations($attributes = [])
    {

        $this->ingredients()->sync(\Arr::get($attributes, 'ingredients', []));
        $this->diningPeriods()->sync(\Arr::get($attributes, 'diningPeriods', []));
    }


    /**
     *  Get the category that owns the meal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)
            ->withTrashed()
            ->withoutGlobalScope('active');
    }



    /**
     * The ingredients that belong to the meal.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    /**
     * The dining periods that belong to the meal.
     */
    public function diningPeriods(): BelongsToMany
    {
        return $this->belongsToMany(DiningPeriod::class);
    }


    /**
     * Get thumbnail.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fileResource($this->files->where('pivot.zone', 'thumbnail')->first())
        );
    }
}