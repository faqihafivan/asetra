<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\FundingSource;
use App\Models\Item;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Categories
        $categories = [
            ['name' => 'ATK', 'description' => 'Alat Tulis Kantor dan perlengkapan administrasi'],
            ['name' => 'Elektronik', 'description' => 'Komputer, printer, projector, dan perangkat elektronik lainnya'],
            ['name' => 'Furniture', 'description' => 'Meja, kursi, lemari, papan tulis, dan sejenisnya'],
            ['name' => 'Peralatan Laboratorium', 'description' => 'Mikroskop, gelas ukur, tabung reaksi, dll'],
            ['name' => 'Peralatan Kebersihan', 'description' => 'Sapu, pel, pembersih kaca, tempat sampah, dll'],
            ['name' => 'Peralatan Olahraga', 'description' => 'Bola sepak, net voli, raket, matras, dll'],
        ];
        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // Seed Suppliers
        $suppliers = [
            [
                'name' => 'PT. Gramedia Asri Media',
                'contact_name' => 'Budi Santoso',
                'phone' => '021-53650110',
                'email' => 'contact@gramedia.com',
                'address' => 'Jl. Palmerah Barat No.29-37, Jakarta'
            ],
            [
                'name' => 'CV. Jaya Abadi Komputer',
                'contact_name' => 'Hendra Wijaya',
                'phone' => '081234567890',
                'email' => 'jaya.abadi.comp@gmail.com',
                'address' => 'Ruko Mangga Dua Square Blok C No. 12, Jakarta'
            ],
            [
                'name' => 'Toko Furniture Sejahtera',
                'contact_name' => 'Ibu Maria',
                'phone' => '082198765432',
                'email' => 'sejahtera.furniture@gmail.com',
                'address' => 'Jl. Raya Bogor Km 25, Depok'
            ],
        ];
        foreach ($suppliers as $sup) {
            Supplier::updateOrCreate(['name' => $sup['name']], $sup);
        }

        // Seed Locations
        $locations = [
            ['name' => 'Gudang Utama', 'description' => 'Penyimpanan pusat aset dan inventaris'],
            ['name' => 'Laboratorium Komputer', 'description' => 'Ruang praktikum komputer sekolah'],
            ['name' => 'Laboratorium Biologi', 'description' => 'Ruang praktikum biologi dan IPA'],
            ['name' => 'Ruang Guru & Staff', 'description' => 'Ruang administrasi dan istirahat guru'],
            ['name' => 'Aula Utama', 'description' => 'Gedung pertemuan dan kegiatan sekolah'],
        ];
        foreach ($locations as $loc) {
            Location::updateOrCreate(['name' => $loc['name']], $loc);
        }

        // Seed Funding Sources
        $fundingSources = [
            ['name' => 'BOS (Bantuan Operasional Sekolah)', 'description' => 'Dana bantuan dari pemerintah pusat'],
            ['name' => 'Komite Sekolah', 'description' => 'Sumbangan sukarela wali murid melalui komite'],
            ['name' => 'Dana Hibah', 'description' => 'Bantuan pihak ketiga non-pemerintah'],
            ['name' => 'Kas Sekolah / Yayasan', 'description' => 'Dana internal sekolah'],
        ];
        foreach ($fundingSources as $fs) {
            FundingSource::updateOrCreate(['name' => $fs['name']], $fs);
        }

        // Seed Items (Initial stock is 0, will increase through procurements)
        $items = [
            [
                'code' => 'AST-2026-0001',
                'name' => 'Kertas HVS A4 80gr',
                'category_id' => 1, // ATK
                'brand' => 'PaperOne',
                'specification' => 'Ukuran A4, ketebalan 80 gsm, isi 500 lembar per rim',
                'unit' => 'Rim',
                'min_stock' => 10,
                'location_id' => 1, // Gudang Utama
                'stock' => 0,
                'description' => 'Kertas untuk cetak dokumen administrasi sekolah',
            ],
            [
                'code' => 'AST-2026-0002',
                'name' => 'Laptop ASUS ExpertBook',
                'category_id' => 2, // Elektronik
                'brand' => 'ASUS',
                'specification' => 'Intel Core i5, RAM 8GB, SSD 512GB, Screen 14 Inch, Win 11 Pro',
                'unit' => 'Unit',
                'min_stock' => 2,
                'location_id' => 2, // Lab Komputer
                'stock' => 0,
                'description' => 'Fasilitas laptop kerja untuk guru',
            ],
            [
                'code' => 'AST-2026-0003',
                'name' => 'Kursi Siswa Kayu',
                'category_id' => 3, // Furniture
                'brand' => 'Lokal',
                'specification' => 'Bahan kayu jati belanda, tinggi dudukan 45 cm, kokoh',
                'unit' => 'Pcs',
                'min_stock' => 5,
                'location_id' => 1, // Gudang Utama
                'stock' => 0,
                'description' => 'Kursi kayu standar kelas',
            ],
            [
                'code' => 'AST-2026-0004',
                'name' => 'Mikroskop Monokuler',
                'category_id' => 4, // Lab Bio
                'brand' => 'Olympus',
                'specification' => 'Pembesaran objektif 4x, 10x, 40x, lensa okuler 10x, lampu LED terintegrasi',
                'unit' => 'Unit',
                'min_stock' => 1,
                'location_id' => 3, // Lab Biologi
                'stock' => 0,
                'description' => 'Mikroskop biologi untuk praktikum siswa',
            ],
        ];
        foreach ($items as $item) {
            Item::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
