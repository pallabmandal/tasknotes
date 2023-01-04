<?php

namespace App\Http\Controllers\v1\Task;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskNoteRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Response;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseHandler;
use App\Exceptions\DataException;
use App\Exceptions\DBOException;

use App\Models\Task;
use App\Models\TaskNote;
use App\Models\TaskNoteAttachment;
use App\Helpers\TaskHelper;

class TaskNoteController extends Controller
{
    use ResponseHandler;

    public function create(CreateTaskNoteRequest $request)
    {
        $inputs = $request->all();
        $user = Auth::user();

        \DB::beginTransaction();
        
        $taskNote = TaskHelper::createNote($inputs['task_id'], $request);

        if($request->hasFile('attachment')){
            $files = $request->file('attachment');
            $addAttachment = TaskHelper::addAttachment($taskNote, $files);
        }

        \DB::commit();
        return $this->buildSuccess(true, $taskNote, 'Task Note created successfully', Response::HTTP_OK);

    }

    public function delete(DeleteTaskNoteRequest $request)
    {
        $inputs = $request->all();
        $user = Auth::user();

        \DB::beginTransaction();
        
        $taskNote = TaskHelper::deleteNote($inputs['task_id']);


        \DB::commit();
        return $this->buildSuccess(true, $taskNote, 'Task Note deleted successfully', Response::HTTP_OK);

    }
}
