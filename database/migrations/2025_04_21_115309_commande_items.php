<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommandeItems extends Migration
{
    public function up()
    {
        Schema::create('commande_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade'); // FK vers commandes
            $table->string('barcode')->nullable(); // peut être null selon produit
            $table->string('name');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->integer('discount')->default(0); // en pourcentage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commande_items');
    }
}
