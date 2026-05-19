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
            ['name'=>'Modern Geometric','slug'=>'modern-geometric','description'=>'Template modern dengan elemen geometris dan animasi elegan','category'=>'modern','color_primary'=>'#1a1a2e','color_secondary'=>'#f8f6f4','color_accent'=>'#c9a87c','font_heading'=>'Italiana','font_body'=>'Josefin Sans','blade_view'=>'templates.modern-geometric','is_premium'=>true,'is_active'=>true,'sort_order'=>6],
            ['name'=>'Romantic Blush','slug'=>'romantic-blush','description'=>'Template romantis dengan warna blush pink yang lembut','category'=>'romantic','color_primary'=>'#D4A5A5','color_secondary'=>'#3D3D3D','color_accent'=>'#F5E6E0','font_heading'=>'Cormorant Garamond','font_body'=>'Montserrat','blade_view'=>'templates.romantic-blush','is_premium'=>false,'is_active'=>true,'sort_order'=>7],
        ];
        foreach ($templates as $t) InvitationTemplate::create($t);
    }
}
