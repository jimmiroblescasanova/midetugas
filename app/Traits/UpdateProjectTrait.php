<?php

namespace App\Traits;

trait UpdateProjectTrait
{
    public function calculatePercentage($project)
    {
        if ($project->total_capacity == 0) {
            return 0;
        }

        return (1 - (($project->total_capacity - $project->actual_capacity) / $project->total_capacity)) * 100;
    }
}
