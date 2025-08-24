<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //Lists the mass assignable fields within the Task object
    protected $fillable = ['title','description','due_date','completed'];

    //Denotes the conversion from data types used in DB to usable PHP
    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',];
}
