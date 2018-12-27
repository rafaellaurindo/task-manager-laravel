<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task Manager",
 *      description="Task Manager Api description",
 *      @OA\Contact(
 *          email="rafaelfilholm@gmail.com",
 *          url="https://rafaellaurindo.com.br"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
