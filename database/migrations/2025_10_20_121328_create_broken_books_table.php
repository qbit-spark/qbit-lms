<?php

use App\Models\DamageType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBrokenBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('damage_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('broken_books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained('books')
                ->onDelete('cascade');

            $table->foreignId('reported_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignIdFor(DamageType::class)
                ->nullable()
                ->constrained('damage_types')
                ->onDelete('set null');

            $table->text('description')->nullable();
            $table->date('damage_date')->nullable();

            $table->enum('status', ['pending', 'under_repair', 'repaired', 'discarded'])
                ->default('pending');

                 $table->enum('deduct_status', ['deducted', 'not_deducted'])
                ->default('not_deducted');

            $table->unsignedInteger('damaged_quantity')->default(1);
            $table->decimal('repair_cost', 10, 2)->default(0.00);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

      
        $damageTypes = [
            'Torn pages',
            'Missing pages',
            'Loose binding',
            'Broken spine',
            'Detached cover',
            'Bent or folded cover',
            'Written or drawn-on pages',
            'Water damage',
            'Stained pages',
            'Mold or mildew',
            'Burnt pages',
            'Insect damage',
            'Missing dust jacket',
            'Incorrect labeling',
        ];

        DB::table('damage_types')->insert(
            collect($damageTypes)->map(fn($type) => ['name' => $type])->toArray()
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broken_books');
        Schema::dropIfExists('damage_types');
    }
}
