<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Imports\ProductImport; //IMPORT CLASS PRODUCTIMPORT YANG AKAN MENG-HANDLE FILE EXCEL
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $category;
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($category, $filename)
    {
        $this->category = $category;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //KEMUDIAN KITA GUNAKAN PRODUCTIMPORT YANG MERUPAKAN CLASS YANG AKAN DIBUAT SELANJUTNYA
      	//IMPORT DATA EXCEL TADI YANG SUDAH DISIMPAN DI STORAGE, KEMUDIAN CONVERT MENJADI ARRAY
          $files = (new ProductImport)->toArray(storage_path('app/public/uploads/' . $this->filename));

      	//KEMUDIAN LOOPING DATANYA
        foreach ($files[0] as $row) {
            // if ($row[4] != '' && filter_var($row[4], FILTER_VALIDATE_URL)) {

          	//FORMATTING URLNYA UNTUK MENGAMBIL FILE-NAMENYA BESERTA EXTENSION
          	//JADI PASTIKAN PADA TEMPLATE MASS UPLOADNYA NANTI PADA BAGIAN URL
          	//HARUS DIAKHIRI DENGAN NAMA FILE YANG LENGKAP DENGAN EXTENSION
            $explodeURL = explode('/', $row[4]);
            $explodeExtension = explode('.', end($explodeURL));
            $filename = time() . Str::random(6) . '.' . end($explodeExtension);

          	//DOWNLOAD GAMBAR TERSEBUT DARI URL TERKAIT
            file_put_contents(storage_path('app/public/products') . '/' . $filename, file_get_contents($row[4]));

          	//KEMUDIAN SIMPAN DATANYA DI DATABASE
            Product::create([
                'name' => $row[0],
                'slug' => $row[0],
                'category_id' => $this->category,
                'description' => $row[1],
                'price' => $row[2],
                'weight' => $row[3],
                'image' => $filename,
                'status' => true
            ]);
            // }
        }
      	//JIKA PROSESNYA SUDAH SELESAI MAKA FILE YANG ADA DISTORAGE AKAN DIHAPUS
        File::delete(storage_path('app/public/uploads/' . $this->filename));

    }
}
