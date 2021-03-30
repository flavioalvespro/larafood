<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $tenant = auth()->user()->tenant;

        $totalUsers = User::where('tenant_id', $tenant->id)->count();

        $totalTables = Table::count();

        $totalCategories = Category::count();
        
        return view('admin.pages.home.home', compact('totalUsers', 'totalTables', 'totalCategories'));
    }
}
