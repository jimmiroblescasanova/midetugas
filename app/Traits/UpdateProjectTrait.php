<?php

namespace App\Traits;

trait UpdateProjectTrait
{
    public function calculatePercentage($project)
    {
        $percentage = (1-(($project->total_capacity - $project->actual_capacity) / $project->total_capacity)) * 100;
        $project['percentage'] = $percentage;
    }
}
