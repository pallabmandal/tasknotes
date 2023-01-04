<?php

namespace App\Http\Controllers\v1\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\ShowTaskRequest;
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


class TaskController extends Controller
{
    use ResponseHandler;

    public function get(Request $request)
    {

        $task = TaskHelper::getTask($request);

        return $this->buildSuccess(true, $task, 'Task fetched successfully', Response::HTTP_OK);

    }

    public function show(ShowTaskRequest $request)
    {
        $inputs = $request->all();

        $task = \App\Models\Task::with([
            'notes:id,task_id,subject,note',
            'notes.attachment:id,task_note_id,file'
        ])->find($inputs['id']);

        return $this->buildSuccess(true, $task, 'Task fetched successfully', Response::HTTP_OK);

    }

    public function create(CreateTaskRequest $request)
    {
        $inputs = $request->all();
        $user = Auth::user();

        $inputs['user_id'] = $user->id;
        \DB::beginTransaction();
        $task = TaskHelper::createTask($inputs);

        if ($request->has('notes') && !empty($inputs['notes'])) {
            $taskNote = TaskHelper::addTaskNote($task->id, $request);
        } 

        \DB::commit();
        return $this->buildSuccess(true, $task, 'Task created successfully', Response::HTTP_OK);

    }
    
    public function update(UpdateTaskRequest $request)
    {
        $inputs = $request->all();

        $user = Auth::user();

        $inputs['user_id'] = $user->id;
        \DB::beginTransaction();
        $task = TaskHelper::updateTask($inputs);
        \DB::commit();
        return $this->buildSuccess(true, $task, 'Task created successfully', Response::HTTP_OK);

    }
}
