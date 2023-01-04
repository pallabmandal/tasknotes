<?php
namespace App\Helpers;

use App\Exceptions\DataException;
use App\Exceptions\DBOException;

use Storage;
use Illuminate\Support\Str;

class TaskHelper {

    public static function createTask($data)
    {
        try {
            
            $task = new \App\Models\Task();
            $task->subject = $data['subject'];
            $task->start_date = \Carbon\Carbon::parse($data['start_date'])->format('Y-m-d');
            if(!empty($data['due_date'])){
                $task->due_date = \Carbon\Carbon::parse($data['due_date'])->format('Y-m-d');
            }
            if(!empty($data['description'])){
                $task->description = $data['description'];
            }
            if(!empty($data['status'])){
                $task->status = $data['status'];
            }
            if(!empty($data['priority'])){
                $task->priority = $data['priority'];
            }

            $task->save();

            return $task;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \App\Exceptions\DBOException($e->getMessage(), 500);
        }
    }

    public static function updateTask($data)
    {
        try {
            
            $task = \App\Models\Task::find($data['id']);
            $task->subject = $data['subject'];
            $task->start_date = \Carbon\Carbon::parse($data['start_date'])->format('Y-m-d');
            if(!empty($data['due_date'])){
                $task->due_date = \Carbon\Carbon::parse($data['due_date'])->format('Y-m-d');
            }
            if(!empty($data['description'])){
                $task->description = $data['description'];
            }
            if(!empty($data['status'])){
                $task->status = $data['status'];
            }
            if(!empty($data['priority'])){
                $task->priority = $data['priority'];
            }

            $task->save();

            return $task;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \App\Exceptions\DBOException($e->getMessage(), 500);
        }
    }

    public static function addTaskNote($task, $request)
    {
        $notes = $request->notes;

        $index = 0;
        $allNotes = [];
        foreach ($notes as $key => $note) {

            $index = $key;

            $newNote = self::createNote($task, $note);

            if($request->hasFile('attachment_'.$index)){
                $files = $request->file('attachment_'.$index);
                $addAttachment = self::addAttachment($newNote, $files);
            }

            $allNotes[] = ['index' => $index, 'note' => $newNote];
        }

        return $allNotes;
    }

    public static function addAttachment($note, $files)
    {
        foreach($files as $file)
        {
            $ext = $file->getClientOriginalExtension();
            $fileName = 'attachment_'.Str::random(5).'_'.time().'.'.$ext;
            $path = 'attachments/'.$fileName;
            $filepath = 'public/attachments/'.$fileName;
            
            Storage::disk('local')->put($filepath, file_get_contents($file), 'public');

            $fileData = new \App\Models\TaskNoteAttachment();
            $fileData->task_note_id = $note->id;
            $fileData->file = $path;
            $fileData->save();
        }
    }


    public static function deleteNote($task)
    {
        $note = \App\Models\TaskNote::find($task);
        $deleteAttachment = \App\Models\TaskNoteAttachment::where('task_note_id', $task)->delete();
        $note->delete();
    }


    public static function getTask($request)
    {
        $inputs = $request->all();

        $tasks = \App\Models\Task::select('tasks.*', 'task_data.note_count');

        $pageSize = 15;
        if(!empty($inputs['page_size'])){
            $pageSize = $inputs['page_size'];
        }
        $tasks = $tasks->leftJoin(\DB::raw('(SELECT count(*) as note_count, task_id from task_notes GROUP BY task_id) as task_data'), 'task_data.task_id', '=', 'tasks.id');

        if(!empty($inputs['filters']['notes'])){
            $tasks = $tasks->where('note_count', '>', '0');
        }
        if(!empty($inputs['filters']['status'])){
            $tasks = $tasks->where('status', $inputs['filters']['status']);
        }
        if(!empty($inputs['filters']['priority'])){
            $tasks = $tasks->where('priority', $inputs['filters']['priority']);
        }
        if(!empty($inputs['filters']['due_date'])){
            $tasks = $tasks->where('due_date', $inputs['filters']['due_date']);
        }

        $sortOrder = $request->input('sort_order', 'DESC');
        $sortBy    = $request->input('sort_by', 'id');
        $tasks = $tasks->orderBy($sortBy, $sortOrder);

        $tasks = $tasks->paginate($pageSize);

        return $tasks;

    }


    public static function createNote($task, $note)
    {
        $newNote = new \App\Models\TaskNote();
        if(empty($note['subject']))
        {
            \DB::rollBack();
            throw new DataException("You can not add a note without a subject");
        }            
        $newNote->task_id = $task;
        $newNote->subject = $note['subject'];

        if(!empty($note['note']))
        {
            $newNote->note = $note['note'];
        }
        try {
            $newNote->save();
        } catch (Exception $e) {
            \DB::rollBack();
            throw new DBOException($e->getMessage());
        }

        return $newNote;
    }

}