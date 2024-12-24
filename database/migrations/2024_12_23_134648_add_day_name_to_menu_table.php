<?php

use App\Models\Menu;
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
        Schema::table('menu', function (Blueprint $table) {
            $table->string('day_name', 10)->after('date');
        });
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        foreach (Menu::all() as $menu) {
            $dayOfWeek = $menu->date->dayOfWeek === 0 ? 6 : $menu->date->dayOfWeek - 1;
            $menu->update(['day_name'=> $days[$dayOfWeek]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('day_name');
        });
    }
};
