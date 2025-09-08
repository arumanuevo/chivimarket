<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'precio'
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }
}

