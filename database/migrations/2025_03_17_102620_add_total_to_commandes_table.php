<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->after('serveur_id')->default(0);
        });

    }

    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
