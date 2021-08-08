<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\RatingBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    //
    public function index()
    {
        // $blogs = Blog::take(8)->get();
        $blogs = Blog::with('ratingBlog')->take(8)->get();

        foreach ($blogs as $blog)
        {
            $totalRatingBlog=count($blog->ratingBlog);
            $totalStars=0;
            foreach($blog->ratingBlog as $rate){
                $totalStars+=$rate->stars;
            }
            if($totalRatingBlog>0){
                $blog->stars= round($totalStars/$totalRatingBlog);
            }






        }
        return view('blogs.index')->with('blogs', $blogs);
    }

    public function show($id)
    {
        //get the blog
        $blog = Blog::find($id);
        if(empty($blog)){
            abort(404);
        }
        //get all Rating Blogs with also the user info of each of them
        $comments =RatingBlog::where('blog_id',$id)->join('users', 'users.id', '=', 'rating_blogs.user_id')->get();

        //check if the user has this blog because if true he con't comment
        $hasThisBlog = false;
        if(Auth::id() == $blog->user_id){
            $hasThisBlog = true;
        }

        //check if the user has already comment in this blog
        $hasCommented= RatingBlog::where('blog_id',$id)->where('user_id',Auth::id());

        $commented =false;
        if (!$hasCommented->get()->isEmpty()) {
            $commented =true;
        }

        //Table of rating blog
        $totalRatingBlog=count($comments);
        $totalStars=0;
        $arrayOfRatingTable=[
            'oneStar'=>['totalNumber'=>0,'starRatio'=>0.0],
            'twoStar'=>['totalNumber'=>0,'starRatio'=>0.0],
            'threeStar'=>['totalNumber'=>0,'starRatio'=>0.0],
            'fourStar'=>['totalNumber'=>0,'starRatio'=>0.0],
            'fiveStar'=>['totalNumber'=>0,'starRatio'=>0.0],
            'totalRatingBlog'=>$totalRatingBlog,
            'averageTotalStars'=>0,

        ];

        foreach($comments as $comment){
            $totalStars+=$comment->stars;
            if($comment->stars ==1)
            {
                $arrayOfRatingTable['oneStar']['totalNumber'] +=1;
            }
            elseif($comment->stars ==2){
                $arrayOfRatingTable['twoStar']['totalNumber'] +=1;
            }
            elseif($comment->stars ==3){
                $arrayOfRatingTable['threeStar']['totalNumber'] +=1;
            }
            elseif($comment->stars ==4){
                $arrayOfRatingTable['fourStar']['totalNumber'] +=1;
            }
            elseif($comment->stars ==5){
                $arrayOfRatingTable['fiveStar']['totalNumber'] +=1;
            };
        }
        if($totalRatingBlog!=0){
            $arrayOfRatingTable['oneStar']['starRatio']= round( ($arrayOfRatingTable['oneStar']['totalNumber']/$totalRatingBlog)*100);
            $arrayOfRatingTable['twoStar']['starRatio']= round( ($arrayOfRatingTable['twoStar']['totalNumber']/$totalRatingBlog)*100);
            $arrayOfRatingTable['threeStar']['starRatio']= round( ($arrayOfRatingTable['threeStar']['totalNumber']/$totalRatingBlog)*100);
            $arrayOfRatingTable['fourStar']['starRatio']= round( ($arrayOfRatingTable['fourStar']['totalNumber']/$totalRatingBlog)*100);
            $arrayOfRatingTable['fiveStar']['starRatio']= round( ($arrayOfRatingTable['fiveStar']['totalNumber']/$totalRatingBlog)*100);

            $arrayOfRatingTable['averageTotalStars']= round($totalStars/$totalRatingBlog,1);
        }




        return view('blogs.show')->with(['blog'=> $blog,'comments'=>$comments,'hasThisBlog'=>$hasThisBlog,'commented'=>$commented,'arrayOfRatingTable'=>$arrayOfRatingTable]);
    }
    public function loadMoreData(Request $request)
    {
        if ($request->ajax()) {
            $skip = $request->skip;
            $take = 8;
            $Blogs = Blog::skip($skip)->take($take)->get();
            return response()->json($Blogs);
        } else {
            return response()->json('Direct Access Not Allowed!!');
        }
    }
    public function addRating(Request $request,$id){
        $data = $request->all();
        $array = ['stars' => $data['star-value'],'comment'=>$data['comment'],'user_id'=>Auth::id(),'blog_id'=>$id];

        RatingBlog::create($array);

        return back();
    }


}
