<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Giriş yapmış kullanıcılar için
            $table->string('ip_address', 45)->nullable(); // IPv6 desteği için 45 karakter
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('country')->nullable();
            $table->string('referer')->nullable();
            $table->string('url')->nullable(); // Ziyaret edilen sayfa URL'si
            $table->integer('visit_count')->default(1); // Ziyaret sayısı
            $table->timestamp('last_visit_at')->nullable(); // Son ziyaret zamanı
            $table->timestamps();

            
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
