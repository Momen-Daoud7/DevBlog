<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'slug' ,'description' , 'image','user_id'];

    //one to many relationship between User and Post
    public function user() { 
    	return $this->belongsTo(User::class);
    }

    //Genreate a slug based on the title
    public function sluggable():  array
    {
    	return [
    		'slug' => [
    			'source' => 'title'
    		]
    	];
    }
}
