<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepository;
use App\Validators\TaskValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class TaskServices
 * @package App\Services
 */
class TaskServices
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var TaskValidator
     */
    private $taskValidator;

    /**
     * TaskServices constructor.
     * @param TaskRepository $taskRepository
     * @param TaskValidator $taskValidator
     */
    public function __construct(TaskRepository $taskRepository, TaskValidator $taskValidator)
    {
        $this->taskRepository = $taskRepository;
        $this->taskValidator = $taskValidator;
    }

    /**
     * @param array $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(array $request)
    {
        $this->taskValidator->with($request)->passesOrFail(ValidatorInterface::RULE_CREATE);

        $task = $this->taskRepository->create($request);

        return $task;
    }

}
