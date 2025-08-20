<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Device
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 * @property string|null $brand
 * @property string|null $model
 * @property string $ip_address
 * @property int $port
 * @property string|null $username
 * @property string|null $password
 * @property string|null $community_string
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $last_seen
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $description
 * @property array|null $monitoring_config
 * @property array|null $last_metrics
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCommunityString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLastMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereMonitoringConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device online()
 * @method static \Illuminate\Database\Eloquent\Builder|Device offline()
 * @method static \Illuminate\Database\Eloquent\Builder|Device active()
 * @method static \Database\Factories\DeviceFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Device extends Model
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
        'brand',
        'model',
        'ip_address',
        'port',
        'username',
        'password',
        'community_string',
        'status',
        'last_seen',
        'latitude',
        'longitude',
        'description',
        'monitoring_config',
        'last_metrics',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_seen' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'monitoring_config' => 'array',
        'last_metrics' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'community_string',
    ];

    /**
     * Get the company that owns this device.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope a query to only include online devices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('status', 'online');
    }

    /**
     * Scope a query to only include offline devices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOffline($query)
    {
        return $query->where('status', 'offline');
    }

    /**
     * Scope a query to only include active devices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}