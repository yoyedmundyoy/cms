<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{

    public function home() {
        return redirect(route('login'));
    }

    public function showLogin() {
        return view('login.index');
    }

    public function showDashboard() {
        return view('admin.index');
    }

    // [Events]

    public function showEvents() {
        return view('admin.events.index');
    }

    public function showEventCreate() {
        return view('admin.events.create');
    }

    public function showEventEdit($id) {
        return view('admin.events.edit', ['data' => Event::all()->find($id)]);
    }

    // End [Events]

    // [Users]

    public function showUsers() {
        return view('admin.users.index');
    }

    public function showUserCreate() {
        return view('admin.users.create');
    }

    public function showUserEdit($id) {
        if ($id == Auth::user()->id) return back()->with('error', 'You cannot edit the details of yourself!');
        if (!(User::all()->find($id))) return back()->with('error', 'Invalid ID, User not found!'); // If the User does not exist, break the request and page render.

        return view('admin.users.edit', ['data' => User::all()->find($id)]);
    }

    // End [Users]

    // [Pages]
    public function showPages() {
        return view('admin.pages.index');
    }

    public function showPageCreate() {
        return view('admin.pages.create');
    }

    public function showPageEdit() {
        return view('admin.pages.edit');
    }

    // End [Pages]

    // [Templates]
    public function showTemplates() {
        return view('admin.templates.index');
    }

    public function showTemplateCreate() {
        return view('admin.templates.create');
    }

    public function showTemplateEdit() {
        return view('admin.templates.edit');
    }

    // End [Templates]

    // [Roles]
    public function showRoles() {
        return view('admin.roles.index');
    }

    // End [Roles]

}
