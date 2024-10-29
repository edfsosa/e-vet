<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Owner extends Model
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Estos campos se pueden rellenar directamente al crear o actualizar un dueño.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ci', // Cédula de identidad del dueño
        'first_name', // Nombre del dueño
        'last_name', // Apellido del dueño
        'gender', // Género del dueño
        'email', // Correo electrónico del dueño
        'phone', // Teléfono del dueño
        'department_id', // ID del departamento de residencia
        'city_id', // ID de la ciudad de residencia
        'neighborhood_id', // ID del barrio de residencia
        'address', // Dirección de residencia
    ];

    /**
     * Un dueño pertenece a un departamento.
     * Esta relación define que cada dueño está asociado con un departamento específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Un dueño pertenece a una ciudad.
     * Esta relación define que cada dueño está asociado con una ciudad específica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Un dueño pertenece a un barrio.
     * Esta relación define que cada dueño está asociado con un barrio específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * Un dueño tiene muchas mascotas.
     * Esta relación define que un dueño puede tener múltiples mascotas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
