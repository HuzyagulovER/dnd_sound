<?php

use App\Models\SoundPack;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ambient', function (Blueprint $table) {
	        $table->uuidId();

	        $table->foreignIdForConstrained(SoundPack::class, comment: 'ID of sound pack', isNullable: false);

	        $table->title(length: 30);
	        $table->description();

	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambient');
    }
};
