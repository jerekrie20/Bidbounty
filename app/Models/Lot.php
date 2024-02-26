<?php

/**
 * Class Lot
 * @package App\Models
 */

namespace App\Models;

use /**
 * Trait HasFactory
 *
 * This trait is used by Eloquent models to easily define and utilize factory
 * callbacks. It provides a convenient method to assign a factory callback
 * to the model and handle the creation of model instances.
 */
    Illuminate\Database\Eloquent\Factories\HasFactory;
use /**
 * Class Illuminate\Database\Eloquent\Model
 *
 * The Illuminate\Database\Eloquent\Model class is the base class for all Eloquent models in Laravel.
 * Eloquent is Laravel's ActiveRecord implementation that allows you to work with databases using a
 * simple object-oriented syntax.
 *
 * @package Illuminate\Database\Eloquent
 */
    Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use /**
 * Class BelongsToMany
 *
 * The BelongsToMany class represents a many-to-many relationship in the Laravel Eloquent ORM.
 * It allows for the retrieval and management of the related records through the pivot table.
 *
 * @package Illuminate\Database\Eloquent\Relations
 */
    Illuminate\Database\Eloquent\Relations\BelongsToMany;
use /**
 * Represents a "has many" relationship in the Eloquent ORM.
 *
 * This class is responsible for defining the relationship between two Eloquent models,
 * where one model has multiple instances of another model. The relationship is defined
 * by specifying the related model class and the foreign key column name on the related model's table.
 *
 * Example usage:
 *  ```
 *  class User extends Illuminate\Database\Eloquent\Model {
 *      public function posts()
 *      {
 *          return $this->hasMany(Post::class);
 *      }
 *  }
 *
 *  class Post extends Illuminate\Database\Eloquent\Model {
 *      public function user()
 *      {
 *          return $this->belongsTo(User::class);
 *      }
 *  }
 *  ```
 *
 * @see https://laravel.com/docs/8.x/eloquent-relationships#one-to-many
 */
    Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Lot
 *
 * @package App\Models
 *
 * @property-read int $id
 * @property-read string $created_at
 * @property-read string $updated_at
 *
 * Relationships:
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Item[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 */
class Lot extends Model
{
    use HasFactory;

    //Start of the relationship

    // Lot can have many items
    public function items() : HasMany
    {
        return $this->hasMany(Item::class, 'lot_id');
    }

    // Lot can have many categories
    public function categories() : belongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    //Lot belongs to a user
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
