<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];

    protected $casts = ['order'=>'string'];
    protected $hidden = ['created_at']; 


    // ---------------------- FİLTRELEME İŞLEMLERİ ----------------------
    public function scopeName($query,$name){
        //dd($name);
        if (!is_null($name)) {
            // return $query->where('name','LIKE','%'.$name.'%');
            return $query->orWhere('name','LIKE','%'.$name.'%');
        }
        
    }
    public function scopeDescription($query,$description){

        if (!is_null($description)) {
            return $query->orWhere('description','LIKE','%'.$description.'%');
        }
        
    }

    public function scopeSlug($query,$slug){

        if (!is_null($slug)) {
            return $query->orWhere('slug','LIKE','%'.$slug.'%');
        }
        
    }

    // ---------------------- FİLTRELEME İŞLEMLERİ ----------------------


    // ---------------------- HASONE İŞLEMLERİ ----------------------
    public function parentCategory():HasOne{
        return $this->hasOne(Category::class,"id","parent_id");
    }

    public function user():HasOne {
        // User Tablosundaki id ile Categories tablosundaki user_id kolonunu
        return $this->hasOne(User::class,"id","user_id");
    }
    // ---------------------- HASONE İŞLEMLERİ ----------------------
}
