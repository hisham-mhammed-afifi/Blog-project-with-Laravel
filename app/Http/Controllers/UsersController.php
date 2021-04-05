<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        return view('users.index')
            ->with('users', User::all())
            ->with('categories', Category::all());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function edit()
    {
        return view('users.edit')
            ->with('user', auth()->user())
            ->with('categories', Category::all());
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->only('image', 'name', 'about');
        if ($request->hasFile('image')) {
            $image = $request->image->store('users');
            $user->deletePhoto();
            $data['image'] = $image;
        }
        $user->update($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.posts')
            ->with('users', User::all())
            ->with('categories', Category::all())
            ->with('user', $user)
            ->with('posts', $user->posts()->searched()->simplePaginate(3));
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function makeAdmin(User $user)
    {
        $user->role ='admin';
        $user->save();
        return redirect()->back();
    }
    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function makeUser(User $user)
    {
        $user->role ='user';
        $user->save();
        return redirect()->back();
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
