<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use App\Events\TodoCreated;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = ToDo::all();
        return view('todo.index', compact('todos'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $todo = ToDo::create(['content' => $data['content']]);

        broadcast(new TodoCreated($data['content']));

        return response()->json(['message' => 'To-Do created successfully']);
    }
}
