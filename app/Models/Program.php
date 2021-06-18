<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $primaryKey = 'program_id';

    protected $table = 'programs';

    protected $fillable = ['program', 'faculty', 'department',  'level', 'status'];

    protected $guarded = ['program_id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_programs', 'program_id', 'course_id')->withPivot('course_required', 'instructor_assigned', 'map_status')->withTimestamps();
    }

    public function mappingScaleLevel()
    {
        return $this->belongsToMany('App\Models\MappingScale', 'mapping_scale_programs', 'map_scale_id', 'program_id');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User', 'program_users', 'user_id', 'program_id');
    }

    // Eloquent automatically determines the FK column for the ProgramLearningOutcome model by taking the parent model (program) and suffix it with _id (program_id)
    public function programLearningOutcomes() {
        return $this->hasMany(ProgramLearningOutcome::class);
    }
}
