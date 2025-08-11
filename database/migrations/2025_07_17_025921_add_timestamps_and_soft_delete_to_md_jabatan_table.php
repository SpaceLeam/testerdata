<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTimestampsAndSoftDeleteToMdJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('md_jabatan', function (Blueprint $table) {
            $table->timestamps(); // Menambahkan created_at dan updated_at
            $table->softDeletes(); // Menambahkan deleted_at untuk soft delete
            $table->timestamp('tanggalubah_jbt')->nullable(); // Kolom tambahan untuk tanggal ubah
        });
        
        // Update existing records dengan timestamp sekarang
        DB::table('md_jabatan')
            ->whereNull('created_at')
            ->orWhereNull('updated_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('md_jabatan', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
            $table->dropColumn('tanggalubah_jbt');
        });
    }
}