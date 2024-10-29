<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Estos campos se pueden rellenar directamente al crear o actualizar un departamento.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Nombre del departamento
        'capital', // Capital del departamento
    ];

    /**
     * Un departamento tiene muchas ciudades.
     * Esta relación define que un departamento puede tener múltiples ciudades asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Un departamento puede tener muchos usuarios.
     * Esta relación podría utilizarse para asociar usuarios a un departamento específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Un departamento puede tener muchos dueños de mascotas.
     * Esta relación podría utilizarse para asociar los dueños de mascotas registrados en la aplicación con el departamento en el que residen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function owners(): HasMany
    {
        return $this->hasMany(Owner::class);
    }
}
