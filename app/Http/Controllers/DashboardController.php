<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $menu = [
        'Issues' => [
            'list' => array('url' => 'dashboard/issues', 'name' => 'List'),
            'create' => array('url' => 'dashboard/issues/create', 'name' => 'Create')
        ]
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['items' => $this->menu]);
    }
}
