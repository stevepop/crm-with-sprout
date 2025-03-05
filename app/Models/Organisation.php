<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sprout\Contracts\Tenant;
use Sprout\Database\Eloquent\Concerns\HasTenantResources;
use Sprout\Database\Eloquent\Concerns\IsTenant;

class Organisation extends Model implements Tenant
{
    use IsTenant, HasTenantResources;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subdomain'
    ];

    /**
     * Get the contacts for the organisation.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the users for the organisation.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getTenantIdentifierName(): string {
        return 'subdomain';
    }
}

