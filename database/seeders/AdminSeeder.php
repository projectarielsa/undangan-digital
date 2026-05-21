<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction() && ! env('ADMIN_PASSWORD')) {
            throw new RuntimeException('ADMIN_PASSWORD wajib diisi di production.');
        }

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'role' => 'super_admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
    }
}
