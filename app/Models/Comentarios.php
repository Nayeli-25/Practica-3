<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comentarios';

    public function relacionProductos()
    {
        /*muchos comentarios pertenecen a un producto*/
        return $this->belongsTo('App\Models\Productos');
    }
    public function relacionPersonas()
    {
        /*muchos comentarios pertencen a una persona*/
        return $this->belongsTo('App\Models\User');
    }
}
