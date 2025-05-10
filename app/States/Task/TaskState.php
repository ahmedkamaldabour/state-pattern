<?php

namespace App\States\Task;

use App\Models\Task;
use App\Models\User;

interface TaskState
{
    public function assign(Task $task, User $user): void;
    public function startProgress(Task $task): void;
    public function block(Task $task): void;
    public function submitForReview(Task $task): void;
    public function approve(Task $task): void; // Mark as Done
    public function reopen(Task $task, string $targetState = 'to-do'): void; // e.g., from blocked to to-do
    public function getStateName(): string;
}