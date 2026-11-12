<?php

namespace WallaceMartinss\FilamentSecurity\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    /**
     * The table has no created_at column. Pointing CREATED_AT at blocked_at
     * makes latest() and oldest() order by the column that actually exists.
     */
    public const CREATED_AT = 'blocked_at';

    public $timestamps = false;

    protected $table = 'security_blocked_ips';

    protected $fillable = [
        'ip_address',
        'reason',
        'cloudflare_rule_id',
        'blocked_at',
        'unblocked_at',
    ];

    protected function casts(): array
    {
        return [
            'blocked_at' => 'datetime',
            'unblocked_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->whereNull('unblocked_at');
    }

    public function isActive(): bool
    {
        return $this->unblocked_at === null;
    }
}
