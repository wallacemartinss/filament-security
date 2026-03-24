<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->string('reason');
            $table->string('cloudflare_rule_id')->nullable();
            $table->timestamp('blocked_at');
            $table->timestamp('unblocked_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_blocked_ips');
    }
};
