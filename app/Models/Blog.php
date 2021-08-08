<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ratingBlog()
    {
        return $this->hasMany(RatingBlog::class);
    }


    public function scopeSearch($query,$val){
        return $query
        ->where('title','like','%'.$val.'%')
        ->Orwhere('content','like','%'.$val.'%')
        ->Orwhere('writer_name','like','%'.$val.'%');
    }
    public function getThumbnailPathAttribute(){

    return substr_replace($this->base_image, '_thumbnail', strpos($this->base_image,'.'),0);
    }
    public function getImagesArrayAttribute(){

        $images= explode (",", $this->images);
        // $imagesArrayWithThumbnail=array();
        // foreach($images as $image){
        //     array_push($imagesArrayWithThumbnail,(object) ["galleryImage" => $image,"thumbnailImage"=>substr_replace($image, '_thumbnail', strpos($image,'.'),0)]);
        // }



        // return $imagesArrayWithThumbnail ;
        return $images;
    }
}
