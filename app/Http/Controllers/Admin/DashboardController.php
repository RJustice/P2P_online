<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use App\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\Category;
use App\Section;
use App\Page;

class DashboardController extends BaseController {

    function __construct()
    {
        parent::__construct('dashboard', '面板');
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}