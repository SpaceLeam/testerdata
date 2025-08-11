<?php
// app/Models/Psr.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Psr extends Model
{
    protected $table = 'md_psr';
    protected $primaryKey = 'id_psr'; // Specify correct primary key
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'id_kdp',
        'cbg_psr', 
        'alamat_psr',
        'longitude_psr',
        'latitude_psr',
        'status_psr'
    ];

    protected $casts = [
        'longitude_psr' => 'decimal:6',
        'latitude_psr' => 'decimal:6',
        'status_psr' => 'integer'
    ];
}