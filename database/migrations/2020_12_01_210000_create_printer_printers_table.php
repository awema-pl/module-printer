
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinterPrintersTable extends Migration
{
    public function up()
    {
        Schema::create(config('printer.database.tables.printer_printers'), function (Blueprint $table) {
            $table->id();
            $table->morphs('printable');
            $table->timestamps();
        });

        Schema::table(config('printer.database.tables.printer_printers'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('printer.database.tables.users'))
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table(config('printer.database.tables.printer_printers'), function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
         Schema::drop(config('printer.database.tables.printer_printers'));
    }
}
