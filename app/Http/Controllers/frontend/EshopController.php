<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EshopController extends Controller
{
    public function eshop(){
        return view('frontend.layout.app');
    }
}