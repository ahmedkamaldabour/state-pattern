<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;

class InReviewState extends BaseState
{
    public function getStateName(): string
    {
        return 'in-review';
    }

    public function approve(Task $task): void
    {
        $task->setState(new DoneState());
    }

    public function reopen(Task $task, string $targetState = 'in-progress'): void
    {
        $task->setState(new ToDoState());
    }
}