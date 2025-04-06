<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserJob extends Model {
        protected $table = 'tbluserjob';
        protected $fillable = ['jobid','jobname'];
        public $timestamps = false;
        protected $primaryKey = 'jobid';
}
