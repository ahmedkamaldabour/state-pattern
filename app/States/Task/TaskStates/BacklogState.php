<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;
use App\Models\User;

class BacklogState extends BaseState
{

    public function getStateName(): string
    {
        return 'backlog';
    }

    public function assign(Task $task, User $user): void
    {
        $task->assigned_to = $user->id;
        $task->setState(new ToDoState());
    }
}