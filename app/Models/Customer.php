<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property int $company_id
 * @property string $customer_id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $whatsapp_number
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string $status
 * @property string|null $connection_type
 * @property string|null $service_plan
 * @property float $monthly_fee
 * @property string|null $installation_date
 * @property string|null $contract_end_date
 * @property string|null $notes
 * @property array|null $custom_fields
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Billing> $billing
 * @property-read \App\Models\Company $company
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereConnectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCustomFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereInstallationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereServicePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereWhatsappNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer active()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer suspended()
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'customer_id',
        'name',
        'email',
        'phone',
        'whatsapp_number',
        'address',
        'latitude',
        'longitude',
        'status',
        'connection_type',
        'service_plan',
        'monthly_fee',
        'installation_date',
        'contract_end_date',
        'notes',
        'custom_fields',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'monthly_fee' => 'decimal:2',
        'installation_date' => 'date',
        'contract_end_date' => 'date',
        'custom_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns this customer.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the billing records for this customer.
     */
    public function billing(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * Scope a query to only include active customers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include suspended customers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
}