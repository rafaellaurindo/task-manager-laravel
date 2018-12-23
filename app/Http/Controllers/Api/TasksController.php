<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TaskRepository;

class TasksController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $repository;

    public function __construct(TaskRepository $repository){
        $this->repository = $repository;
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
        $tasks = $this->repository->skipPresenter()->paginate($limit);

        return response()->json($tasks, 200);
    }
}
