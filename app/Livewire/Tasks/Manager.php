<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Manager extends Component
{
    public $tasks;
    public $display = false;

    public ?int $taskID = null;
    public bool $completed = false;

    //Validation decorators that require these properties to adhere to rules
    #[Validate('required|string|min:3')]
    public string $title = '';

    #[Validate('required|date')]
    public string $due_date = '';

    public string $filter = 'all';

    public ?string $description = null;

    //Lifecycle hook that runs on instantiating of component 
    public function mount(): void {

        $this->loadTasks();
    }

    //Lifecycle hook that returns Blade view
    public function render() {

        return view('livewire.tasks.manager')->layout('components.layouts.app', ['title' => 'Tasks']);
    }

    //Calls orderBy method on Task class to return task objects based on their due date. Based on the status of the filter
    //property, we agument the query based on completion
    public function loadTasks(): void {

        $query = Task::orderBy('due_date');

        if ($this->filter === 'completed') {

            $query->where('completed', true);
        } else if ($this->filter === 'uncompleted') {

            $query->where('completed', false);
        }

        $this->tasks = $query->get();
    }

    public function filterTasks(): void{
        
        if ($this->filter === 'all') {

            $this->filter = 'completed';
        } else if ($this->filter === 'completed') {

            $this->filter = 'uncompleted';
        } else {

            $this->filter = 'all';
        }

        $this->loadTasks();
    }

    //Resets the form from previous entries and displays the modal
    public function create(): void {

        $this->resetForm();
        $this->display = true;
    }

    //Searches for the task based on its ID and populates modal with data
    public function edit(int $id): void {

        $task = Task::findOrFail($id);

        $this->taskID = $task->id;
        $this->completed = $task->completed;
        $this->title = $task->title;
        $this->schedule_date = $task->due_date->format('Y-m-d');
        $this->description = $task->description;

        $this->display = true;
    }

    public function save():  void {

        //Calls the validate method to ensure properties that have defined rules are following them
        $this->validate();

        $data = [

            'completed' => $this->completed,
            'title' => $this->title,
            'due_date' => $this->due_date,
            'description' => $this->description
        ];

        //Verifies that the component ID matches a previously stored entry, otherwise creates a new entry
        if ($this->taskID) {

            Task::whereKey($this->taskID)->update($data);
        } else {
            
            Task::create($data);
        }

        $this->display = false;

        $this->resetForm();
        $this->loadTasks();
    } 

    public function toggleComplete($id): void {

        $task = Task::findOrFail($id);

        //Evaluates current status of completed boolean and swaps it
        $task->completed = ! $task->completed;

        $task->save();
        $this->loadTasks();
    }

    public function deleteEntry(int $id): void {

        Task::whereKey($id)->delete();

        $this->loadTasks();
    }

    public function resetForm(): void {

        $this->reset(['taskID', 'completed', 'title', 'due_date', 'description']);
    }
}
