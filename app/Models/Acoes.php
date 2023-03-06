<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    use HasFactory;

    //definir nome real da table na base dedados

    protected $table = 'tb_issues';

    //mudar nome primary key
    protected $primaryKey = 'idissue';

    //mudar nome do timestamp
    const CREATED_AT = 'dtregister';

    
    //desativar updated at e afins
    public $timestamps = false;
}
