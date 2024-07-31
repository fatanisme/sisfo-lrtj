<?php

namespace App\Http\Controllers\Api;

//import model Stamformasi
use App\Models\Stamformasi;

use App\Http\Controllers\Controller;

//import resource PostResource
use App\Http\Resources\PostResource;
use App\Http\Resources\StatuslrvResource;

class StatuslrvController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Stamformasi::latest()->paginate(5);

        //return collection of posts as a resource
        return new StatuslrvResource(true, 'List Data Status LRV', $posts);
    }
}
