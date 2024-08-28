<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
       $menus = Menu::with('children.sub_children')->whereNull('parent_id')->get();
        return response()->json(['message' => 'Menus retrieved','menus' => $menus], 200);
    }

    public function show(Menu $menu)
    {
        $menu->load('children');
        return response()->json(['message' => 'Menu retrieved','menu' => $menu], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'depth' => 'required|integer',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $menu = Menu::create($request->all());
        return response()->json(['message' => 'Menu created','data' => $menu], 201);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'depth' => 'required|integer',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $menu->update($request->all());
        return response()->json(['message' => 'Menu updated','data' => $menu], 200);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['message' => 'Menu deleted'], 200);
    }
}
