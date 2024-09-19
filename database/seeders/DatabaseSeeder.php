<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $domains = [
            ['domain' => 'https://class-kits.com/check-server', 'name' => 'Class Kits'],
            ['domain' => 'https://l.aalamy.org/check-server', 'name' => 'Aalamy'],
            ['domain' => 'https://testapi.investsama.com/check-server', 'name' => 'Invest Sama'],
            ['domain' => 'https://api.zahi.live', 'name' => ' Zahi Live'],
            ['domain' => 'https://test-api.zahi.live', 'name' => ' Test Zahi Live'],
            ['domain' => 'https://price.lamsetshefaa.net/check-server', 'name' => 'Lamset Shefaa Price for pharmacy'],
            ['domain' => 'https://api.lamsetshefaa.sy/check-server', 'name' => 'Lamset Shefaa '],
            ['domain' => 'https://api.driverjy.sy/check-server', 'name' => 'Driverjy'],
            ['domain' => 'https://careup.sy/check-server', 'name' => 'CareUp'],
            ['domain' => 'https://fcm.tamayouz-me.com/check-server', 'name' => 'Tamayouz FCM for All PROJECTS'],
            ['domain' => 'https://joybox-me.com/check-server', 'name' => 'JoyBox '],
            ['domain' => 'https://gamesbox-me.com/check-server', 'name' => 'GamesBox & HAPPY CAPY'],
            ['domain' => 'http://api.university.gamesbox-me.com/check-server', 'name' => 'GamesBox University FUTURE GATE'],
            ['domain' => 'https://araborient-trn.com/check-server', 'name' => 'Arab Orient'],
            ['domain' => 'https://pharmacist.dr-ayman.net/check-server', 'name' => 'Dr. Ayman - pharmacist'],
            ['domain' => 'https://apimaysoon.dr-ayman.net/check-server', 'name' => 'Dr. Ayman - maysoon'],
            ['domain' => 'https://rahaf-t.com/check-server', 'name' => 'Rahaf T'],
            ['domain' => 'https://pharmacist.dr-ayman.net/check-server', 'name' => 'Pharmacist'],
            ['domain' => 'https://l.aalamy.org:3000/health-check', 'name' => 'Aalamy Node real time'],
            ['domain' => 'https://class-kits.com:3000/health-check', 'name' => 'class-kits node real time'],
        ];
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@joybox.com',
            'password' => 'Uu123456',
        ]);
        foreach ($domains as $domain){
        Domain::factory()->create([
            'url'=>$domain['domain'],
            'name'=>$domain['name']
        ]);
        }
    }
}
