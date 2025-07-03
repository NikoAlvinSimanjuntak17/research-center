<?php

// app/Models/Project.php

namespace App\Models;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'open_at',
        'close_at',
        'created_by',
        'created_by_admin',
        'approval_status',
        'leader_id', // GANTI ke researcher_id
        'progress_status',
       'rejection_reason',
    ];

    protected $casts = [
        'open_at' => 'date',
        'close_at' => 'date',
        
    ];

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function getStatusAttribute()
    {
        $now = now();
        
        if ($now->lt($this->open_at)) {
            return 'upcoming';
        }
        
        if ($now->between($this->open_at, $this->close_at)) {
            return 'open';
        }
        
        return 'close';
    }

    // Di model Project.php
    public function leader()
    {
        return $this->belongsTo(Researcher::class, 'leader_id');
    }

    public function scopeOpen($query)
    {
        $now = now();
        return $query->where('open_at', '<=', $now)
        ->where('close_at', '>=', $now);
    }

    public function scopeClosed($query)
    {
        $now = now();
        return $query->where('close_at', '<', $now);
    }


    
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }
    
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }
    
    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }
 
    public function publication() {
        return $this->hasOne(Publication::class);
    }
    
    public function updateProgressStatus()
    {
        $now = Carbon::now();
        
        if ($this->progress_status === 'completed') {
            return; // Jangan ubah kalau sudah selesai
        }
        
        if (is_null($this->open_at) || is_null($this->close_at)) {
            return; // Tidak bisa update tanpa tanggal yang valid
        }
        
        if ($now->lt($this->close_at)) {
            // Belum tutup pendaftaran (baik sebelum open_at atau antara open_at - close_at)
            $this->progress_status = 'not_started';
        } else {
            // Sudah lewat dari close_at, artinya riset dimulai
            $this->progress_status = 'in_progress';
        }
        
        $this->save();
    }

    public function scopeNotStarted($query)
    {
        return $query->where('progress_status', 'not_started');
    }
    
    public function scopeInProgress($query)
    {
        return $query->where('progress_status', 'in_progress');
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('progress_status', 'completed');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
