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
     * @OA\Get(
     *      path="/tasks",
     *      operationId="getTasksList",
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Returns list of tasks",
     *      @OA\Parameter(
     *          name="limit",
     *          description="Data limit.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Page.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="search",
     *          description="Search by task name, description or priority.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal server error")
     *)
     *
     * Returns list of tasks.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->taskRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $tasks = $this->taskRepository->paginate($request->limit ?? 10);

        return response()->json($tasks, 200);
    }

    /**
     * @OA\Get(
     *      path="/tasks/{id}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task information",
     *      description="Returns task data.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Display the specified task.
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
     * @OA\Post(
     *      path="/tasks",
     *      operationId="createNewTask",
     *      tags={"Tasks"},
     *      summary="Create a new task",
     *      description="Create a new task.",
     *      @OA\Parameter(
     *          name="name",
     *          description="Task name.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Task description.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="priority",
     *          description="Task priority.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              enum={"Baixa", "Média", "Alta", "Muito Alta"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="term",
     *          description="Task term.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_completed",
     *          description="Task is completed?",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              enum={0, 1},
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     *  Store a newly created task in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $task = $this->taskService->store($request->all());

        return response()->json($task, 201);
    }

    /**
     * @OA\Put(
     *      path="/tasks/{id}",
     *      operationId="updateATask",
     *      tags={"Tasks"},
     *      summary="Update a task",
     *      description="Update a task.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Task name.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Task description.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="priority",
     *          description="Task priority.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              enum={"Baixa", "Média", "Alta", "Muito Alta"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="term",
     *          description="Task term.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_completed",
     *          description="Task is completed?",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              enum={0, 1},
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=202, description="Accepted"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Update the specified task in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request, $id)
    {
        $task = $this->taskService->update($request->all(), $id);

        return response()->json($task, 202);
    }

    /**
     * @OA\Delete(
     *      path="/tasks/{id}",
     *      operationId="deleteTaskById",
     *      tags={"Tasks"},
     *      summary="Delete a task",
     *      description="Delete a task.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=204, description="No Content"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Remove the specified task from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->taskService->destroy($id);
        return response()->json([], 204);
    }

}
