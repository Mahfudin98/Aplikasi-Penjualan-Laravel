<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with(['parent'])->orderBy('created_at', 'DESC')->paginate(10);
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();

        return view('kategori.kategori', compact('category', 'parent'));
    }

    public function store(Request $request)
    {
        //JADI KITA VALIDASI DATA YANG DITERIMA, DIMANA NAME CATEGORY WAJIB DIISI
        //TIPENYA ADA STRING DAN MAX KARATERNYA ADALAH 50 DAN BERSIFAT UNIK
        //UNIK MAKSUDNYA JIKA DATA DENGAN NAMA YANG SAMA SUDAH ADA MAKA VALIDASINYA AKAN MENGEMBALIKAN ERROR
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories'
        ]);

        //FIELD slug AKAN DITAMBAHKAN KEDALAM COLLECTION $REQUEST
        $request->request->add(['slug' => $request->name]);

        //SEHINGGA PADA BAGIAN INI KITA TINGGAL MENGGUNAKAN $request->except()
        //YAKNI MENGGUNAKAN SEMUA DATA YANG ADA DIDALAM $REQUEST KECUALI INDEX _TOKEN
        //FUNGSI REQUEST INI SECARA OTOMATIS AKAN MENJADI ARRAY
        //CATEGORY::CREATE ADALAH MASS ASSIGNMENT UNTUK MEMBERIKAN INSTRUKSI KE MODEL AGAR MENAMBAHKAN DATA KE TABLE TERKAIT
        Category::create($request->except('_token'));

        return redirect(route('category.index'))->with(['success' => 'Kategori Baru Ditambahkan!']);
    }

    public function edit($id)
    {
        $category = Category::find($id); //QUERY MENGAMBIL DATA BERDASARKAN ID
        $parent = Category::getParent()->orderBy('name', 'ASC')->get(); //INI SAMA DENGAN QUERY YANG ADA PADA METHOD INDEX

        //LOAD VIEW EDIT.BLADE.PHP PADA FOLDER CATEGORIES
        //DAN PASSING VARIABLE CATEGORY & PARENT
        return view('kategori.edit', compact('category', 'parent'));
    }

    public function update(Request $request, $id)
    {
        //VALIDASI FIELD NAME
        //YANG BERBEDA ADA TAMBAHAN PADA RULE UNIQUE
        //FORMATNYA ADALAH unique:nama_table,nama_field,id_ignore
        //JADI KITA TETAP MENGECEK UNTUK MEMASTIKAN BAHWA NAMA CATEGORYNYA UNIK
        //AKAN TETAPI KHUSUS DATA DENGAN ID YANG AKAN DIUPDATE DATANYA DIKECUALIKAN
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $category = Category::find($id); //QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        //KEMUDMIAN PERBAHARUI DATANYA
        //POSISI KIRI ADALAH NAMA FIELD YANG ADA DITABLE CATEGORIES
        //POSISI KANAN ADALAH VALUE DARI FORM EDIT
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        //REDIRECT KE HALAMAN LIST KATEGORI
        return redirect(route('category.index'))->with(['success' => 'Kategori Diperbaharui!']);
    }

    public function destroy($id)
    {
        //Buat query untuk mengambil category berdasarkan id menggunakan method find()
        //ADAPUN withCount() SERUPA DENGAN EAGER LOADING YANG MENGGUNAKAN with()
        //HANYA SAJA withCount() RETURNNYA ADALAH INTEGER
        //JADI NNTI HASIL QUERYNYA AKAN MENAMBAHKAN FIELD BARU BERNAMA child_count YANG BERISI JUMLAH DATA ANAK KATEGORI
        $category = Category::withCount(['child'])->find($id);
        //JIKA KATEGORI INI TIDAK DIGUNAKAN SEBAGAI PARENT ATAU CHILDNYA = 0
        if ($category->child_count == 0) {
            //MAKA HAPUS KATEGORI INI
            $category->delete();
            //DAN REDIRECT KEMBALI KE HALAMAN LIST KATEGORI
            return redirect(route('category.index'))->with(['success' => 'Kategori Dihapus!']);
        }
        //SELAIN ITU, MAKA REDIRECT KE LIST TAPI FLASH MESSAGENYA ERROR YANG BERARTI KATEGORI INI SEDANG DIGUNAKAN
        return redirect(route('category.index'))->with(['error' => 'Kategori Ini Memiliki Anak Kategori!']);
    }
}
