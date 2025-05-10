<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;
use App\Models\User;
use RuntimeException;

class DoneState extends BaseState
{

    public function getStateName(): string
    {
        return 'done';
    }

    // Override all methods to prevent changes from the "done" state
    public function assign(Task $task, User $user): void
    {
        throw new RuntimeException('Cannot change state or assign user when task is done.');
    }

    public function startProgress(Task $task): void
    {
        throw new RuntimeException('Cannot change state when task is done.');
    }

    public function block(Task $task): void
    {
        throw new RuntimeException('Cannot change state when task is done.');
    }

    public function submitForReview(Task $task): void
    {
        throw new RuntimeException('Cannot change state when task is done.');
    }

    public function approve(Task $task): void
    {
        throw new RuntimeException('Task is already done.');
    }

    public function reopen(Task $task, string $targetState = 'to-do'): void
    {
        throw new RuntimeException('Cannot reopen a done task.');
    }

}