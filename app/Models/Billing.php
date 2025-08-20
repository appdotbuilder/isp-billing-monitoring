<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Billing
 *
 * @property int $id
 * @property int $company_id
 * @property int $customer_id
 * @property string $invoice_number
 * @property string $billing_date
 * @property string $due_date
 * @property float $amount
 * @property float $tax_amount
 * @property float $total_amount
 * @property string $status
 * @property string|null $payment_method
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $description
 * @property array|null $line_items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Customer $customer
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereLineItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Billing pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Billing paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Billing overdue()
 * @method static \Database\Factories\BillingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Billing extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'customer_id',
        'invoice_number',
        'billing_date',
        'due_date',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'payment_method',
        'paid_at',
        'description',
        'line_items',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'billing_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'line_items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns this billing record.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the customer for this billing record.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope a query to only include pending billing records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid billing records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include overdue billing records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }
}