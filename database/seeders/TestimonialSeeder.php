<?php
namespace Database\Seeders;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name'=>'Ahmad & Siti','message'=>'Undangan digitalnya sangat cantik dan elegan! Tamu-tamu kami sangat terkesan.','rating'=>5,'sort_order'=>1],
            ['name'=>'Budi & Dewi','message'=>'Prosesnya sangat mudah dan cepat. Desainnya premium sekali, sangat recommended!','rating'=>5,'sort_order'=>2],
            ['name'=>'Reza & Putri','message'=>'Fitur RSVP-nya sangat membantu mengatur jumlah tamu. Best investment!','rating'=>5,'sort_order'=>3],
            ['name'=>'Fajar & Rina','message'=>'Kami sangat puas dengan layanannya. Undangan kami terlihat sangat profesional.','rating'=>5,'sort_order'=>4],
            ['name'=>'Dimas & Anisa','message'=>'Template Islamic Elegant-nya sangat indah! Sesuai tema pernikahan kami.','rating'=>5,'sort_order'=>5],
            ['name'=>'Irfan & Maya','message'=>'Musik background dan countdown timer-nya bikin undangan terasa hidup!','rating'=>5,'sort_order'=>6],
        ];
        foreach ($testimonials as $t) Testimonial::create($t);
    }
}
