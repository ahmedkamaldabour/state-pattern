<?php

namespace App\States\Task;

use App\States\Task\TaskStates\BacklogState;
use App\States\Task\TaskStates\BlockedState;
use App\States\Task\TaskStates\DoneState;
use App\States\Task\TaskStates\InProgressState;
use App\States\Task\TaskStates\InReviewState;
use App\States\Task\TaskStates\ToDoState;
use InvalidArgumentException;

class TaskStateFactory
{
    public static function make(string $stateName): BacklogState|BlockedState|DoneState|InProgressState|InReviewState|ToDoState
    {
        return match ($stateName) {
            'backlog' => new BacklogState(),
            'to-do' => new ToDoState(),
            'in-progress' => new InProgressState(),
            'blocked' => new BlockedState(),
            'in-review' => new InReviewState(),
            'done' => new DoneState(),
            default => throw new InvalidArgumentException("Unknown state: {$stateName}"),
        };
    }
}