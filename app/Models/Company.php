<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $logo
 * @property string $type
 * @property int|null $parent_id
 * @property bool $is_active
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $children
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Device> $devices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read \App\Models\Company|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Billing> $billing
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company active()
 * @method static \Illuminate\Database\Eloquent\Builder|Company parents()
 * @method static \Illuminate\Database\Eloquent\Builder|Company tenants()
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'logo',
        'type',
        'parent_id',
        'is_active',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent company.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    /**
     * Get the child companies (tenants).
     */
    public function children(): HasMany
    {
        return $this->hasMany(Company::class, 'parent_id');
    }

    /**
     * Get the users for this company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the devices for this company.
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Get the customers for this company.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the employees for this company.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get the billing records for this company.
     */
    public function billing(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * Scope a query to only include active companies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include parent companies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParents($query)
    {
        return $query->where('type', 'parent');
    }

    /**
     * Scope a query to only include tenant companies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTenants($query)
    {
        return $query->where('type', 'tenant');
    }
}