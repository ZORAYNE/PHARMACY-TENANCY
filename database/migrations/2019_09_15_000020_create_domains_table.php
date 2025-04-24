<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id'); // This MUST match the tenants.id type
            $table->string('domain')->unique();
            $table->timestamps();
            
            $table->foreign('tenant_id', 'fk_domains_tenant_id') // Explicitly name the foreign key if needed
                  ->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
}
