<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;
use App\Http\Controllers\Controller;
use App\Http\Transformers\TaskTransformer;
use Response;

class TaskController extends Controller
{
    protected $TaskTransformer;
    protected $tagTransformer;

    public function __construct(TaskTransformer $TaskTransformer)
    {
         $this->TaskTransformer = $TaskTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transformer = new TaskTransformer();

        $tasks = Task::get();


        return Response::json(
            $this->TaskTransformer->transformCollection($tasks),
            200
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->all());
        return ['created' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if(!$task){
            return response() -> json([
            "msg" => "does not exist"            
            ], 404
        );
        } else {

        return Response::json(
            $this->TaskTransformer->transform($task),
            200
        );

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request->all());
        return ['updated' => true];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return ['deleted' => true];
    }

    public function transformCollection($task)
    {
     return array_map([$this, 'transform'],$task->toArray());
    }
    public function transform($task)
    {
        return [
            'name' => $task['name'],
            'done' => $task['done'],
            'priority' => $task['priority']
        ];
            

    }
    
}
