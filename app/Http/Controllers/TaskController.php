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
        // Obtém todas as tasks do banco de dados
        $tasks = Task::all();
    
        // Retorna a view 'tasks.index' passando as tasks
        return view('task.index', compact('tasks'));
    }
      
    
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'responsible' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
    
        // Criação da tarefa no banco de dados
        $task = new Task();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'] ?? null; 
        $task->responsible = $validatedData['responsible'] ?? null;
        $task->category = $validatedData['category'] ?? null;
        $task->start_date = Carbon::now('America/Sao_Paulo');
        $task->status = $validatedData['status'];

        $task->save();

        // Redireciona para uma página de sucesso ou lista de tasks
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id); // Busca a task pelo ID
        return view('task.edit', compact('task')); // Retorna a view com a task
    }

    // Método para atualizar o status e o end_date
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,started,paused,finished',
        ]);

        $task = Task::findOrFail($id); // Busca a task pelo ID
        $task->status = $validatedData['status'];



        // Se o status for 'finished', atualiza o end_date com a data e hora atuais
        if ($validatedData['status'] == 'finished') {
            $task->end_date = Carbon::now('America/Sao_Paulo');
        }

        $task->save(); // Salva a task atualizada no banco de dados

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }
    
}
