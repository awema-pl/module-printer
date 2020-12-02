
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinterSettingsTable extends Migration
{
    public function up()
    {
        Schema::create(config('printer.database.tables.printer_settings'), function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('printer.database.tables.printer_settings'));
    }
}
