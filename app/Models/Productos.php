<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos';
    public $timestamps = false;

    public function relacionComentarios()
    {
        /*un producto tiene muchos comentarios*/
        return $this->hasMany('App\Models\Comentarios');
    }
}
