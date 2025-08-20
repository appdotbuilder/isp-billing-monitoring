<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\NetworkInfrastructure
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 * @property float $latitude
 * @property float $longitude
 * @property string|null $address
 * @property int|null $capacity
 * @property int $used_capacity
 * @property string $status
 * @property int|null $parent_device_id
 * @property string|null $description
 * @property array|null $specifications
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Device|null $parentDevice
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure query()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereParentDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereSpecifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure whereUsedCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkInfrastructure active()

 * 
 * @mixin \Eloquent
 */
class NetworkInfrastructure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'type',
        'latitude',
        'longitude',
        'address',
        'capacity',
        'used_capacity',
        'status',
        'parent_device_id',
        'description',
        'specifications',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'capacity' => 'integer',
        'used_capacity' => 'integer',
        'specifications' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns this infrastructure.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the parent device for this infrastructure.
     */
    public function parentDevice(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'parent_device_id');
    }

    /**
     * Scope a query to only include active infrastructure.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}