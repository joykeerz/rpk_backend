<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFile extends Model
{
    use HasFactory;
    protected $table = 'category_file';
    protected $fillable = [
        'file_name',
        // 'file_path',
        // 'file_type',
        // 'file_size',
    ];
}
