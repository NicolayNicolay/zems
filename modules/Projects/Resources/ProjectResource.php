<?php

declare(strict_types=1);

namespace Modules\Projects\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Enums\StatusEnum;
use Modules\Projects\Models\Projects;

/**
 * Class ProjectResource
 *
 * @mixin Projects
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'date'        => $this->created_at,
            'tasks'       => $this->groupTasks(),
        ];
    }

    private function groupTasks()
    {
        $result = (object) [
            'ideas'      => [],
            'todos'      => [],
            'inProgress' => [],
            'completed'  => [],
        ];
        $states = StatusEnum::array();
        if ($this->tasks) {
            foreach ($this->tasks as $task) {
                $result->{$states[$task['state']]}[] = $task;
            }
        }
        return $result;
    }
}
