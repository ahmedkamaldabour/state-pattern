<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;

class ToDoState extends BaseState
{
    public function getStateName(): string
    {
        return 'to-do';
    }

    public function startProgress(Task $task): void
    {
        $task->setState(new InProgressState());
    }

    public function block(Task $task): void
    {
        // A task can be blocked if it's picked up
        $task->setState(new BlockedState());
    }

}