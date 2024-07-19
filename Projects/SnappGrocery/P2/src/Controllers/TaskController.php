<?php

namespace Amir\Todolist\Controllers;

use Amir\Todolist\Request\Resource;
use Amir\Todolist\Models\TaskModel;

class TaskController extends BaseController
{

    public function getAll()
    {
        $taskModel = new TaskModel();
        $result = $taskModel->getAll();

        foreach ($result as $key => $item) {
            $result[$key]['status'] = array_search($item['status'], TaskModel::STATUS);
        }

        return new Resource(200, true, "", $result);
    }

    public function create($request)
    {
        $data = $request->getBody();

        $validation = self::ValidateTaskData($data);
        $taskModel = new TaskModel();

        if ($validation['status']) {
            $title = $data['title'];
            $description = $data['description'];
            $taskModel->create($title, $description, TaskModel::STATUS['pending']);

            return new Resource(201, true, "Created successfully");
        }

        return new Resource(400, false, $validation['message']);
    }

    public function update($request, $task_id)
    {
        $data = $request->getBody();

        $validation = self::ValidateTaskData($data);
        $taskModel = new TaskModel();

        if ($validation['status']) {

            $previous_task = $taskModel->get($task_id);

            if (empty($previous_task)) {
                return new Resource(404, false, "Task ${task_id} Not Found");
            }

            $title = $data['title'];
            $description = $data['description'];
            $status = TaskModel::STATUS[$data['status']];

            $taskModel->update($task_id, $title, $description, $status);

            return new Resource(200, true, "Updated successfully");
        }

        return new Resource(400, false, $validation['message']);
    }

    public static function ValidateTaskData($data)
    {

        if (empty($data['title'])) {
            return ['status' => false, 'message' => 'Title is required'];
        }

        if (empty($data['description'])) {
            return ['status' => false, 'message' => 'Description is required'];
        }

        if (isset($data['status']) && !in_array($data['status'], array_keys(TaskModel::STATUS))) {
            return ['status' => false, 'message' => 'Invalid status'];
        }

        return ['status' => true, 'message' => ''];
    }
}