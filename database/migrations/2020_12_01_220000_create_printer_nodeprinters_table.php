
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinterNodeprintersTable extends Migration
{
    public function up()
    {
        Schema::create(config('printer.database.tables.printer_nodeprinters'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('api_key');
            $table->text('location');
            $table->unsignedBigInteger('printer_id');
            $table->timestamps();
        });

        Schema::table(config('printer.database.tables.printer_nodeprinters'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('printer.database.tables.users'))
                ->onDelete('cascade');
        });

        Schema::table(config('printer.database.tables.printer_nodeprinters'), function (Blueprint $table) {
            $table->unique(['user_id', 'printer_id']);
        });

    }

    public function down()
    {
        Schema::table(config('printer.database.tables.printer_nodeprinters'), function (Blueprint $table) {
            $table->dropUnique(['user_id', 'printer_id']);
            $table->dropForeign(['user_id']);
        });
         Schema::drop(config('printer.database.tables.printer_nodeprinters'));
    }
}
