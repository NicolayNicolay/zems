<?php

declare(strict_types=1);

namespace Modules\Statistics\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Modules\Projects\Models\Projects;

class StatisticService
{
    public function getStatistic(): array
    {
        $projects = (new Projects())->get();
        $data = [];
        foreach ($projects as $project) {
            $tmp_item = [
                'name' => $project->name,
                'h'    => 0,
                'm'    => 0,
            ];
            foreach ($project->tasks as $task) {
                if ($task->start && $task->end) {
                    $start = $task->start;
                    $end = $task->end;
                    $time = Carbon::parse($end)->diff(Carbon::parse($start));
                    $minutes = $time->format('%i.%s');
                    $minutes = round((float) $minutes);
                    $hours = $time->format('%h');
                    $tmp_item['h'] += (int) $hours;
                    $tmp_item['m'] += (int) $minutes;
                }
            }
            $data[] = $tmp_item;
        }
        $result = [];
        $max = 0;
        foreach ($data as $datum) {
            $result['x'][] = $datum['name'];
            $result['y'][] = $datum['h'] . '.' . $datum['m'];
            $max = (float) $datum['h'] . '.' . $datum['m'];
        }
        $result['max'] = $max;
        return $result;
    }
}
