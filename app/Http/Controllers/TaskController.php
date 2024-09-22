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
        
        // Verifica se a tarefa pode ser pausada
        if ($validatedData['status'] == 'paused') {
            if ($task->status !== 'started') {
                return redirect()->back()->withErrors(['status' => 'Cannot pause a task that has not been started.']);
            }
            if ($task->status === 'finished') {
                return redirect()->back()->withErrors(['status' => 'Cannot pause a task that has already been finished.']);
            }
        }

        // Verifica se a tarefa pode ser finalizada
        if ($validatedData['status'] == 'finished') {
            if ($task->status !== 'started') {
                return redirect()->back()->withErrors(['status' => 'Cannot finish a task that has not been started.']);
            }
        }

        // Atualiza o status da tarefa
        $task->status = $validatedData['status'];

        // Se o status for 'finished', atualiza o end_date com a data e hora atuais
        if ($validatedData['status'] == 'finished') {
            $task->end_date = Carbon::now('America/Sao_Paulo');
        }

        $task->save(); // Salva a task atualizada no banco de dados

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    
}
