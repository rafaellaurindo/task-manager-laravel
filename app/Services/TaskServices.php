<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepository;
use App\Validators\TaskValidator;

class TaskServices
{
    private $taskRepository;
    private $taskValidator;

    public function __construct(TaskRepository $taskRepository, TaskValidator $taskValidator)
    {
        $this->taskRepository = $taskRepository;
        $this->taskValidator = $taskValidator;
    }

}
