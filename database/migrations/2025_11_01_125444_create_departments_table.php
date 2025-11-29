<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- include this for DB::table()

return new class extends Migration
{
    public function up(): void
    {
        // Avoid re-creating if already exists
        if (Schema::hasTable('departments')) {
            return;
        }

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Optional: add default sample data
        DB::table('departments')->insert([
            ['name' => 'Finance'],
            ['name' => 'HR'],
            ['name' => 'IT'],
            ['name' => 'Operations'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
