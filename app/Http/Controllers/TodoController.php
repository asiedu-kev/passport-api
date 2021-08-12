<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    protected $errorCode = 500;
    protected $successCode = 200;
    public function index()
    {
        $todos = auth()->user()->todos();

        return response()->json([
            'sucess'=> true,
            'data' => $todos
        ]);
    }
    
    public function show($id)
    {
        $todo = auth()->user()->todos()->find($id);

        if(!$todo) 
        {
            $message = 'Tache non trouve';
            return response()->json(['error_message' => $message],$this->errorCode);
        }
        return response()->json(['todo' => $todo->toArray()],$this->successCode);
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'title' => 'required',
            'description' => 'required',
        ]);
        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;

        if (auth()->user()->todos()->save($todo)){
            return response()->json(['success' => true, 'todo' => $todo->toArray()], $this->successCode);
        }
        else {
            $error_message = 'Tache non ajoute';
            return response()->json(['success' => false, 'message' => $error_message], $this->errorCode);
        }
    }

    public function update(Request $request,$id)
    {
        $todo = auth()->user()->todos()->find($id);
        if(!$todo) 
        {
            $message = 'Tache non trouve';
            return response()->json(['error_message' => $message],$this->errorCode);
        }
        $updated = $todo->fill($request->all())->save();

        if($updated)
        {
            return response()->json(['success'=>true]);
        }
        else
        {
            $message = 'Impossible de mettre a jour';
            return response()->json(['error_message' => $message], $this->errorCode);
        }
    }

    public function destroy($id)
    {
        $todo = auth()->user()->todos()->find($id);
        if(!$todo) 
        {
            $message = 'Tache non trouve';
            return response()->json(['error_message' => $message],$this->errorCode);
        }
        if ($todo->delete()) 
        {
            return response()->json(['success' => true], $this->successCode);
        }
        else 
        {
            $error_message = 'Tache non supprimee';
            return response()->json(['success' =>false, 'error_message' => $error_message],$this->errorCode);
        }
    }

}
