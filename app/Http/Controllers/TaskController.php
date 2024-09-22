<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();          
        return view('task.index', compact('tasks'));
    }
      
    
    public function store(Request $request)
    {       
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'responsible' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'required',
        ]);    
        
        $task = new Task();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'] ?? null; 
        $task->responsible = $validatedData['responsible'] ?? null;
        $task->category = $validatedData['category'] ?? null;
        $task->start_date = Carbon::now('America/Sao_Paulo');
        $task->status = $validatedData['status'];

        $task->save();
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('task.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,started,paused,finished',
        ]);

        $task = Task::findOrFail($id);
        $task->status = $validatedData['status'];

        if ($validatedData['status'] == 'finished') {
            $task->end_date = Carbon::now('America/Sao_Paulo');
        }

        $task->save(); 

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }
    
}
