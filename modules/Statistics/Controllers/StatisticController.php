<?php

declare(strict_types=1);

namespace Modules\Statistics\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Forms\ProjectForm;
use Modules\Projects\Models\Projects;
use Modules\Projects\Resources\ProjectResource;
use Modules\Statistics\Services\StatisticService;
use Modules\Tasks\Forms\TasksForm;

class StatisticController extends Controller
{
    public function index(StatisticService $service): array
    {
        return $service->getStatistic();
    }
}
