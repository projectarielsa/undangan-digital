<?php
namespace Database\Seeders;
use App\Models\InvitationTemplate;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['name'=>'Elegant Gold','slug'=>'elegant-gold','description'=>'Template elegan dengan aksen emas yang mewah','category'=>'elegant','color_primary'=>'#D4AF37','color_secondary'=>'#1a1a2e','color_accent'=>'#f8f0e3','font_heading'=>'Playfair Display','font_body'=>'Lato','blade_view'=>'templates.elegant-gold','is_premium'=>false,'is_active'=>true,'sort_order'=>1],
            ['name'=>'Minimal White','slug'=>'minimal-white','description'=>'Desain minimalis bersih dengan nuansa putih modern','category'=>'minimal','color_primary'=>'#2d2d2d','color_secondary'=>'#ffffff','color_accent'=>'#f5f5f5','font_heading'=>'Cormorant Garamond','font_body'=>'Montserrat','blade_view'=>'templates.minimal-white','is_premium'=>false,'is_active'=>true,'sort_order'=>2],
            ['name'=>'Luxury Black','slug'=>'luxury-black','description'=>'Template mewah dengan tema gelap dan aksen emas','category'=>'luxury','color_primary'=>'#C9A96E','color_secondary'=>'#0d0d0d','color_accent'=>'#1a1a1a','font_heading'=>'Cinzel','font_body'=>'Raleway','blade_view'=>'templates.luxury-black','is_premium'=>true,'is_active'=>true,'sort_order'=>3],
            ['name'=>'Floral Romantic','slug'=>'floral-romantic','description'=>'Template romantis dengan ornamen bunga','category'=>'floral','color_primary'=>'#8B4513','color_secondary'=>'#FFF8F0','color_accent'=>'#FFE4E1','font_heading'=>'Great Vibes','font_body'=>'Open Sans','blade_view'=>'templates.floral-romantic','is_premium'=>true,'is_active'=>true,'sort_order'=>4],
            ['name'=>'Islamic Elegant','slug'=>'islamic-elegant','description'=>'Template Islami elegan dengan ornamen geometris','category'=>'islamic','color_primary'=>'#1B5E20','color_secondary'=>'#F5F5DC','color_accent'=>'#E8F5E9','font_heading'=>'Amiri','font_body'=>'Poppins','blade_view'=>'templates.islamic-elegant','is_premium'=>true,'is_active'=>true,'sort_order'=>5],
            ['name'=>'Indonesia Classic','slug'=>'indonesia-classic','description'=>'Template klasik Indonesia dengan ornamen batik Jawa','category'=>'traditional','color_primary'=>'#6B5B4B','color_secondary'=>'#FAF7F2','color_accent'=>'#C4A97D','font_heading'=>'Marcellus','font_body'=>'Jost','blade_view'=>'templates.indonesia-classic','is_premium'=>true,'is_active'=>true,'sort_order'=>6],
            ['name'=>'Rustic Garden','slug'=>'rustic-garden','description'=>'Template rustic dengan nuansa alam dan botanis','category'=>'rustic','color_primary'=>'#4A6741','color_secondary'=>'#3D3929','color_accent'=>'#C4956A','font_heading'=>'Amatic SC','font_body'=>'Josefin Sans','blade_view'=>'templates.rustic-garden','is_premium'=>true,'is_active'=>true,'sort_order'=>7],
            ['name'=>'Modern Geometric','slug'=>'modern-geometric','description'=>'Template modern dengan bentuk geometris bold','category'=>'modern','color_primary'=>'#1B2A4A','color_secondary'=>'#C17F59','color_accent'=>'#F8F9FC','font_heading'=>'Bebas Neue','font_body'=>'Work Sans','blade_view'=>'templates.modern-geometric','is_premium'=>true,'is_active'=>true,'sort_order'=>8],
            ['name'=>'Vintage Rose','slug'=>'vintage-rose','description'=>'Template vintage dengan nuansa dusty rose antik','category'=>'vintage','color_primary'=>'#C4888B','color_secondary'=>'#A06568','color_accent'=>'#FAF3EB','font_heading'=>'EB Garamond','font_body'=>'Lora','blade_view'=>'templates.vintage-rose','is_premium'=>true,'is_active'=>true,'sort_order'=>9],
            ['name'=>'Tropical Paradise','slug'=>'tropical-paradise','description'=>'Template tropis dengan warna cerah dan daun palm','category'=>'tropical','color_primary'=>'#E8756D','color_secondary'=>'#2BA5A5','color_accent'=>'#FFF8F0','font_heading'=>'Pacifico','font_body'=>'Nunito','blade_view'=>'templates.tropical-paradise','is_premium'=>true,'is_active'=>true,'sort_order'=>10],
        ];
        foreach ($templates as $t) {
            InvitationTemplate::updateOrCreate(
                ['slug' => $t['slug']],
                $t
            );
        }
    }
}
