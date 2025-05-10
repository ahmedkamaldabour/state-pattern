<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;

class InProgressState extends BaseState
{

    public function getStateName(): string
    {
        return 'in-progress';
    }

    public function submitForReview(Task $task): void
    {
        $task->setState(new InReviewState());
    }

    public function block(Task $task): void
    {
        $task->setState(new BlockedState());
    }
}