<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TaskServices;
use App\Repositories\Contracts\TaskRepository;

class TasksController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * @var TaskServices
     */
    protected $taskService;

    public function __construct(TaskRepository $taskRepository, TaskServices $taskService){
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of tasks with pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $tasks = $this->taskRepository->skipPresenter()->paginate($limit);

        return response()->json($tasks, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = $this->taskRepository->skipPresenter()->find($id);

        return response()->json($task, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $task = $this->taskService->store($request->all());

        return response()->json($task, 201);
    }

}
