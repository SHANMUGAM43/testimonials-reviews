<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->paginate(10);
        return view('index', compact('testimonials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $testimonial = Testimonial::updateOrCreate(
            [
                'id' => $request->testimonialId
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'rating'=> $request->rating,
                'status'=> $request->status,
                'message'=> $request->message,
            ]
        );

        if ($testimonial) {
            return response()->json(['status' => 'success', 'data' => $testimonial]);
        }
        return response()->json(['status' => 'failed', 'message' => 'Failed! testimonial not created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        if ($testimonial) {
            return response()->json(['status' => 'success', 'data' => $testimonial]);
        }
        return response()->json(['status' => 'failed', 'message' => 'No testimonial found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json(['status' => 'success', 'data' => $testimonial]);
    }
    
}
