<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Publication;
use App\Models\Department;
use App\Models\Project;
use App\Models\ResearchData;

class Researcher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'orcid_id',
        'scopus_id',
        'garuda_id',
        'googlescholar_id',
        'image',
        'created_by',
        'updated_by',
        'nip',
        'bachelor_degree',
        'master_degree',
        'doctor_degree',
        'experiences',
        'citation_count',
        'active',
        'name',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'publication_researcher', 'researcher_id', 'publication_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'leader_id');
    }

    public function researchDatas()
    {
        return $this->hasMany(ResearchData::class, 'researcher_id');
    }
}
    