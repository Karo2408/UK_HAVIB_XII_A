    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateProdukTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('produk', function (Blueprint $table) {
                $table->increments('ProdukID');
                $table->string('NamaProduk', 100);
                $table->unsignedInteger('KategoriID');
                $table->decimal('Harga', 10, 2);
                $table->integer('Stok');
                $table->string('Foto')->nullable(); // path/file gambar produk
                $table->timestamps();

                $table->foreign('KategoriID')->references('KategoriID')->on('kategori')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('produk');
        }
    }
