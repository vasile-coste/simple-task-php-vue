<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    /**
     * @var Tasks
     */
    private Tasks $task;

    /**
     * @var AjaxResponse
     */
    private AjaxResponse $ajaxResponse;

    /**
     * @param Tasks $task
     * @param AjaxResponse $ajaxResponse
     */
    public function __construct(Tasks $task, AjaxResponse $ajaxResponse)
    {
        $this->task = $task;
        $this->ajaxResponse = $ajaxResponse;
    }

    public function view()
    {
        return view("newtask");
    }

    /**
     * @param Request $request
     * 
     * @return string
     */
    public function all(Request $request): string
    {
        $rules = [
            'user' => 'required',
        ];

        $data = $request->only('user', 'status');

        $validator = Validator::make($data,  $rules);

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());

        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($errors)
                ->toJson();
        }

        $getTasks = $this->task->getAll($data['user'], $data['status'] ? $data['status'] : '');

        return $this->ajaxResponse
            ->setLocation('/')
            ->setData($getTasks)
            ->setSuccess(true)
            ->setMessage("Task list")
            ->toJson();
    }

    /**
     * @param Request $request
     * 
     * @return string
     */
    public function create(Request $request): string
    {
        $rules = [
            'user' => 'required',
            'name' => 'required',
            'due' => 'required',
            'status' => 'required'
        ];

        $data = $request->only('user', 'name', 'due', 'status');

        $validator = Validator::make($data,  $rules);

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());

        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($errors)
                ->toJson();
        }

        $createTask = $this->task->createTask($data['user'], $data['name'], $data['due'], $data['status']);

        if ($createTask) {
            return $this->ajaxResponse
                ->setLocation('/')
                ->setSuccess(true)
                ->setMessage("Task created")
                ->toJson();
        }

        return $this->ajaxResponse
            ->setLocation('/')
            ->setMessage("Something went wrong.")
            ->toJson();
    }

    /**
     * @param array $msgs
     * 
     * @return array
     */
    private function getValidatorMsg(array $msgs): array
    {
        $result = [];
        foreach ($msgs as $msg) {
            $result[] = implode("\n", $msg);
        }

        return $result;
    }
}
