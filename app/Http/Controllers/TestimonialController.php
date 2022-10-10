<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Http\Traits\JsonUtilTrait;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use JsonUtilTrait;

    public function store(Request $request)
    {
        //$name = $request::file('file')->getClientOriginalName();
        $file = $request->file('file');
        if ($file != null) {
            $path = public_path('photos/');
            $file_name = date('mdYHis') . $file->getClientOriginalName();
            $file_name = str_replace(' ', '-', strtolower($file_name));
            $file_name = str_replace('(', '-', strtolower($file_name));
            $file_name = str_replace(')', '-', strtolower($file_name));
            $file->move($path, $file_name);
            $image_url = url('photos') . "/" . $file_name;
        } else {
            $image_url = null;
        }



        Testimonial::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'file'   => $image_url,
            'rating'  => $request->rating,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Testimonial Successfully created',
            'status' => 200,
            'success' => true,
        ]);
    }
    public function get()
    {
        $testimonials = Testimonial::where('status', 1)->orderBy('id', 'DESC')->select('name', 'rating', 'message')->paginate(10);
        $testimonials_count = Testimonial::where('status', 1)->select('name', 'rating', 'message')->count();

        if($testimonials_count != 0)
        {
            $test_view="";
     
        foreach ($testimonials as $test) {
            $test_view .= $test;

        }

        return $this->responseWithData('Succesful',$testimonials);

        }
        else{

            return $this->responseWithError("Empty");

        }
        
    }

    public function index1() {
        $shop2 = User::where('email','shop@shanz-hero.myshopify.com')->first(); //name of your store
        $shop = Auth::loginUsingId($shop2->id, TRUE);
        $shopApi = $shop->api()->rest('GET', '/admin/customers.json');
        //dd($shopApi['body']['container']['customers'][2]['first_name']);
        echo $shopApi['body']['container']['customers'][2]['first_name'];
        }
}

