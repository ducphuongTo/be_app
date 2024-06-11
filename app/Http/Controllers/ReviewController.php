<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function update(Request $request)
    {
        $messages =[
            'title.required'=>'Please fill in the title field',
            'details.required'=>'Please fill in the detail field',
            'rating.required'=>'Please select the rating star',

        ];
        $validate = Validator::make($request->all(),[
            'reviewer_name' => ['required', 'string', 'max:120'],
            'review_details' => ['string'],
            'rating_star' => ['required'],
        ], $messages);

        if($validate->fails()){
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                404
            );
        }
        $date = Carbon::now();
        Review::create([
            'product_id'=>$request->id,
            'reviewer_name' => $request->reviewer_name,
            'review_details' => $request-> review_details,
            'review_date' =>$date->toDateTimeString(),
            'rating_star'=> $request->rating_star,
        ]);
        return response()->json(
            [
                'message' => "Review updated",
            ],
            201
        );
    }
}
