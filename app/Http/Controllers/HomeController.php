<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
    }

    public function userCan($action, $option = NULL)
    {

        $user = Auth::user();

        return Gate::forUser($user)->allows($action, $option);

    }

    public function showPageGuest()
    {

        if (!$this->userCan('isUser')) {

            abort('403', __('Bạn không có quyền thực hiện thao tác này'));

        }

        return view("welcome");

    }


    public function showPageAdmin()
    {

        if (!$this->userCan('isAdmin')) {

            abort('403', __('Bạn không có quyền thực hiện thao tác này'));

        }

       // return view("layouts.page_admin");
       return view("layouts.admin");

    }
}
