<?php

namespace App\Models;


use App\States\Task\TaskState;
use App\States\Task\TaskStateFactory;
use App\States\Task\TaskStates\BacklogState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Default state

class Task extends Model
{
    use HasFactory;

    /**
     * @var int|mixed
     */
    protected $fillable = ['title', 'description', 'assigned_to', 'state'];

    /**
     * The current state object of the task.
     * This is not persisted directly in the database.
     *
     * @var TaskState |null
     */
    protected TaskState|null $currentStateObject = null;

    /**
     * Boot the model.
     * Set default state to 'backlog' when creating a new Task.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (empty($task->state)) {
                $task->state = (new BacklogState())->getStateName();
            }
        });

// Ensure currentStateObject is loaded after model retrieval
        static::retrieved(function ($task) {
            $task->getCurrentStateObject();
        });
    }


    /**
     * Get the current state object.
     * Initializes it if not already set.
     */
    public function getCurrentStateObject(): TaskState
    {
        if ($this->currentStateObject === null) {
            if (empty($this->state)) { // Should be set by boot() or from DB
                $this->state = (new BacklogState())->getStateName();
            }
            // get the state object from the factory
            $this->currentStateObject = TaskStateFactory::make($this->state);
        }
        return $this->currentStateObject;
    }

    /**
     * Set the state of the task using a TaskState object.
     * This method is called by the state objects during transitions.
     */
    public function setState(TaskState $newState): void
    {
        $this->state = $newState->getStateName();
        $this->currentStateObject = $newState;
        // The save() call will be handled by the controller or calling action
        // to ensure it's part of a transaction if needed.
    }

// Delegate actions to the current state object

    public function assign(User $user): void
    {
        $this->getCurrentStateObject()->assign($this, $user);
        $this->save(); // Persist changes after state transition
    }

    public function startProgress(): void
    {
        $this->getCurrentStateObject()->startProgress($this);
        $this->save();
    }

    public function block(): void
    {
        $this->getCurrentStateObject()->block($this);
        $this->save();
    }

    public function submitForReview(): void
    {
        $this->getCurrentStateObject()->submitForReview($this);
        $this->save();
    }

    public function approve(): void // This is effectively markAsDone
    {
        $this->getCurrentStateObject()->approve($this);
        $this->save();
    }

    public function reopen(string $targetState = 'to-do'): void
    {
        $this->getCurrentStateObject()->reopen($this, $targetState);
        $this->save();
    }

// Accessor for the state name (string) if needed directly
    public function getStateName(): string
    {
        return $this->getCurrentStateObject()->getStateName();
    }

    // on smart method for all states
    public function changeState(string $stateName): void
    {
        $stateFunction = $stateName();
        $this->getCurrentStateObject()->$stateFunction($this);
        $this->save();
    }

// Relationship with User
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}