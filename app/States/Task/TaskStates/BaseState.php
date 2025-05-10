<?php

namespace App\States\Task\TaskStates;

use App\Models\Task;
use App\Models\User;
use App\States\Task\TaskState;

abstract class BaseState implements TaskState
{
    protected function transitionNotAllowed(string $action): void
    {
        throw new \RuntimeException("Action '{$action}' not allowed from state '{$this->getStateName()}'.");
    }

    public function assign(Task $task, User $user): void
    {
        $this->transitionNotAllowed('assign');
    }

    public function startProgress(Task $task): void
    {
        $this->transitionNotAllowed('startProgress');
    }

    public function block(Task $task): void
    {
        $this->transitionNotAllowed('block');
    }

    public function submitForReview(Task $task): void
    {
        $this->transitionNotAllowed('submitForReview');
    }

    public function approve(Task $task): void
    {
        $this->transitionNotAllowed('approve');
    }

    public function reopen(Task $task, string $targetState = 'to-do'): void
    {
        $this->transitionNotAllowed('reopen');
    }
}