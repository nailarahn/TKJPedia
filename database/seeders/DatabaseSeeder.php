<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roadmap;
use App\Models\Stage;
use App\Models\UserRoadmap;
use App\Models\UserStage;
use App\Models\Target;
use App\Models\Badge;
use App\Models\LearningLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // USERS
        // ==========================================
        $user = User::create([
            'name'     => 'Gema Pelajar',
            'username' => 'tupaikidal123',
            'email'    => 'tupaikidal@mappypath.id',
            'password' => Hash::make('Kambingguling_001'),
            'role'     => 'student',
        ]);

        User::create([
            'name'     => 'Admin MappyPath',
            'username' => 'admin',
            'email'    => 'admin@mappypath.id',
            'password' => Hash::make('Admin@123'),
            'role'     => 'admin',
        ]);

        // ==========================================
        // ROADMAP 1 - Pengenalan Jaringan Komputer (beginner) - CP 4
        // ==========================================
        $r1 = Roadmap::create([
            'title'           => 'Pengenalan Jaringan Komputer',
            'description'     => 'Tahap awal TKJ: pengenalan perangkat jaringan dan cara kerja jaringan dasar (CP 4).',
            'slug'            => 'pengenalan-jaringan-komputer',
            'level'           => 'beginner',
            'category'        => 'networking',
            'total_stages'    => 4,
            'estimated_hours' => 2,
            'order'           => 1,
        ]);

        $s1data = [
            // [group_label, title, description, url, menit, learning_points]
            [
                'Dasar Jaringan Komputer',
                'Pengertian dan Jenis Jaringan Komputer',
                'Memahami apa itu jaringan komputer, manfaatnya, dan mengenal LAN, MAN, dan WAN beserta perbedaannya.',
                'https://youtu.be/WPhjxoVDygk?si=_BTGBhRiU0nsRp4J',
                7,
                "Definisi jaringan komputer\nManfaat jaringan\nKomponen dasar jaringan\nContoh jaringan sehari-hari\nLAN (Local Area Network)\nMAN (Metropolitan Area Network)\nWAN (Wide Area Network)\nPerbandingan jangkauan dan penggunaan",
            ],
            [
                'Dasar Jaringan Komputer',
                'Topologi Jaringan',
                'Mengenal berbagai topologi jaringan dan penerapannya.',
                'https://youtu.be/lRNcZEgWrw4?si=N2Ww75bt7n4MjqsT',
                7,
                "Topologi Bus\nTopologi Star\nTopologi Ring\nTopologi Mesh\nKelebihan dan kekurangan tiap topologi",
            ],
            [
                'Perangkat Jaringan',
                'Pengenalan Perangkat Jaringan',
                'Mengenal router, switch, hub, access point, dan modem.',
                'https://youtu.be/N2CNS1N9gZo?si=cltK03mgv5hHY_ue',
                8,
                "Router dan fungsinya\nSwitch vs Hub\nAccess Point\nModem\nPerbedaan fungsi antar perangkat",
            ],
            [
                'Perangkat Jaringan',
                'Fungsi dan Cara Kerja Perangkat Jaringan',
                'Memahami cara kerja masing-masing perangkat jaringan.',
                'https://youtu.be/jokDcCuMABY?si=tPDrIDtOddhZ2LlO',
                5,
                "Cara kerja router\nCara kerja switch\nCara kerja access point\nSkenario jaringan sederhana",
            ],

        ];

        $stageIds1 = [];
        foreach ($s1data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r1->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds1[] = $st->id;
        }
        $r1->update(['total_stages' => count($stageIds1)]);

        // ==========================================
        // ROADMAP 2 - Konsep Jaringan & Komunikasi Data (intermediate) - CP 6
        // ==========================================
        $r2 = Roadmap::create([
            'title'           => 'Konsep Jaringan & Komunikasi Data',
            'description'     => 'Tahap inti TKJ: model OSI, TCP/IP, pengalamatan IP, subnetting, dan keamanan jaringan dasar (CP 6).',
            'slug'            => 'konsep-jaringan-komunikasi-data',
            'level'           => 'intermediate',
            'category'        => 'networking',
            'total_stages'    => 9,
            'estimated_hours' => 4,
            'order'           => 2,
        ]);

        $s2data = [
            [
                'Konsep Jaringan Dasar',
                'IPv4 & IPv6',
                'Memahami dasar sistem pengalamatan IP.',
                'https://youtu.be/lP-gtvo_cuc?si=dojRSjM-lYM2iuCB',
                11,
                "IPv4\nIPv6\nPerbedaan IP\nFungsi IP address",
            ],
            [
                'Konsep Jaringan Dasar',
                'TCP/IP Model',
                'Memahami model TCP/IP sebagai dasar komunikasi internet.',
                'https://youtu.be/0RedyOvvkM0?si=2tHHAm8wZhWyQ7hA',
                27,
                "4 lapisan TCP/IP\nPerbandingan OSI vs TCP/IP\nBagaimana internet bekerja\nProtokol tiap lapisan",
            ],
            [
                'Konsep Jaringan Dasar',
                'Networking Service',
                'Memahami layanan jaringan dasar.',
                'https://youtu.be/5a71GbrNC8U?si=T6UdHnqTPb-_Aeys',
                3,
                "DNS\nDHCP\nHTTP\nFTP",
            ],
            [
                'Komunikasi Data',
                'Keamanan Jaringan Telekomunikasi',
                'Dasar keamanan jaringan telekomunikasi.',
                'https://youtu.be/rr24pcYNb-E?si=5NwUDhtVaoxROleZ',
                11,
                "Firewall\nEnkripsi\nAncaman jaringan\nProteksi data",
            ],
            [
                'Komunikasi Data',
                'Sistem Seluler',
                'Mengenal jaringan seluler modern.',
                'https://youtu.be/FISGFwPR5mo?si=siHi7FXy0Vl13Dce',
                3,
                "2G 3G 4G 5G\nBase station\nSIM card\nMobile network",
            ],
            [
                'Telekomunikasi',
                'Microwave System',
                'Teknologi komunikasi microwave.',
                'https://youtu.be/d7uVG7YSRiE?si=VQAmMEc6GW9hQzk1',
                3,
                "Gelombang mikro\nLine of sight\nTransmisi data\nAntena microwave",
            ],
            [
                'Telekomunikasi',
                'VSAT IP',
                'Sistem komunikasi satelit VSAT.',
                'https://youtu.be/f6SEQhe1cNs?si=LVAapbopenn8dXTO',
                3,
                "VSAT\nSatelit komunikasi\nRemote area network\nInternet satelit",
            ],
            [
                'Telekomunikasi',
                'Fiber Optic',
                'Komunikasi menggunakan serat optik.',
                'https://youtu.be/wBfRcaliKjE?si=EomKGaBamvpiAR3A',
                4,
                "Serat optik\nKecepatan cahaya\nTransmisi data\nBandwidth tinggi",
            ],
            [
                'Wireless',
                'WLAN',
                'Teknologi jaringan nirkabel.',
                'https://youtu.be/85k0sn7ZYoE?si=dLnVgsE9RdE26qsa',
                4,
                "WiFi\nAccess point\nWireless network\nKeamanan WLAN",
            ],
        ];

        $stageIds2 = [];
        foreach ($s2data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r2->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds2[] = $st->id;
        }
        $r2->update(['total_stages' => count($stageIds2)]);

        // ==========================================
        // ROADMAP 3 - Proses Bisnis & Teknologi Jaringan Modern (advanced) - CP 1 & CP 2
        // ==========================================
        $r3 = Roadmap::create([
            'title'           => 'Proses Bisnis & Teknologi Jaringan Modern',
            'description'     => 'Tahap akhir TKJ: proses bisnis, peran teknisi, cloud computing, IoT, dan virtualisasi (CP 1 & CP 2).',
            'slug'            => 'proses-bisnis-teknologi-jaringan',
            'level'           => 'advanced',
            'category'        => 'networking',
            'total_stages'    => 6,
            'estimated_hours' => 3,
            'order'           => 3,
        ]);

        $s3data = [
            [
                'Proses Bisnis Jaringan',
                'Proses Bisnis di Bidang Jaringan',
                'Memahami alur kerja dan peran teknisi jaringan di industri.',
                'https://youtu.be/zq4rOPsIcZU?si=s2ijkaVy3AMUUQv-',
                11,
                "Peran teknisi jaringan\nAlur kerja di industri\nDokumentasi jaringan\nKomunikasi dengan klien",
            ],
            [
                'Proses Bisnis Jaringan',
                'Maintenance Jaringan',
                'Proses pemeliharaan jaringan secara berkala.',
                'https://youtu.be/G-bIiAA_dNo?si=T7caT-vHVnx75puV',
                16,
                "Pengecekan jaringan\nUpdate perangkat\nMonitoring sistem\nJadwal maintenance",
            ],
            [
                'Proses Bisnis Jaringan',
                'Troubleshooting Dasar',
                'Metode dasar mengatasi masalah jaringan.',
                'https://youtu.be/ZQ2YB5ihyFM?si=whzz7C09qFtpN5R8',
                23,
                "Identifikasi masalah\nTools jaringan\nAnalisis gangguan\nSolusi error",
            ],
            [
                'Teknologi Modern',
                'Cloud Computing',
                'Konsep layanan komputasi berbasis cloud.',
                'https://youtu.be/iw3pCL8UiX8?si=gDiPzprgfnYNu7nZ',
                10,
                "Pengertian cloud computing\nModel layanan: IaaS\nPaaS\nSaaS\nCloud deployment",
            ],
            [
                'Teknologi Modern',
                'Internet of Things (IoT)',
                'Konsep IoT dan penerapannya dalam kehidupan nyata.',
                'https://youtu.be/n-f8B76Hozk?si=26L6ph1xP0dgkb4H',
                2,
                "Pengertian IoT\nKomponen sistem IoT\nProtokol IoT (MQTT)\nContoh implementasi IoT",
            ],
            [
                'Teknologi Modern',
                'Virtualisasi Jaringan',
                'Teknologi membuat sistem virtual dalam satu perangkat fisik.',
                'https://youtu.be/fckgHc2JwQs?si=D-mIlactMpdc3apu',
                9,
                "Virtual machine\nHypervisor\nCloud infrastructure\nEfisiensi server",
            ],
        ];

        $stageIds3 = [];
        foreach ($s3data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r3->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds3[] = $st->id;
        }
        $r3->update(['total_stages' => count($stageIds3)]);

        // ==========================================
        // ENROLLMENT - User ke R1 (aktif, sedang berjalan)
        // ==========================================
        UserRoadmap::create([
            'user_id'    => $user->id,
            'roadmap_id' => $r1->id,
            'progress'   => 50,           // 3 dari 6 stage selesai = 50%
            'status'     => 'active',
            'started_at' => now()->subWeeks(2),
        ]);

        // 3 stage pertama r1 sudah diselesaikan user
        foreach (array_slice($stageIds1, 0, 3) as $i => $sid) {
            UserStage::create([
                'user_id'             => $user->id,
                'stage_id'            => $sid,
                'roadmap_id'          => $r1->id,
                'is_completed'        => true,
                'completed_at'        => now()->subDays(12 - ($i * 3)),
                'time_spent_minutes'  => rand(15, 35),
            ]);
        }

        // ==========================================
        // TARGETS
        // ==========================================
        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Selesaikan Pengenalan Jaringan Komputer',
            'type'          => 'custom',
            'target_value'  => 6,
            'current_value' => 3,
            'deadline'      => now()->addDays(20)->toDateString(),
            'status'        => 'active',
        ]);

        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Belajar 5 materi per minggu',
            'type'          => 'weekly',
            'target_value'  => 5,
            'current_value' => 4,
            'deadline'      => now()->endOfWeek()->toDateString(),
            'status'        => 'active',
        ]);

        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Raih 10 Badge',
            'type'          => 'custom',
            'target_value'  => 10,
            'current_value' => 12,
            'deadline'      => null,
            'status'        => 'done',
        ]);

        // ==========================================
        // BADGES
        // ==========================================
        $badgesData = [
            ['Pemula',       '🌱', '#22c55e', 'stages_done',  1],
            ['Rajin Belajar','📚', '#3b82f6', 'stages_done', 10],
            ['Streak 7 Hari','🔥', '#f97316', 'streak',       7],
            ['Road Master',  '🏆', '#f59e0b', 'roadmap_done', 1],
            ['Networker',    '🌐', '#372466', 'stages_done',  5],
            ['Konsisten',    '⭐', '#8b5cf6', 'streak',       30],
        ];

        foreach ($badgesData as $b) {
            $badge = Badge::create([
                'name'            => $b[0],
                'icon'            => $b[1],
                'color'           => $b[2],
                'condition_type'  => $b[3],
                'condition_value' => $b[4],
                'description'     => "Badge {$b[0]}",
            ]);

            // 4 badge pertama sudah diraih user
            if ($badge->id <= 4) {
                $user->badges()->attach($badge->id, [
                    'earned_at' => now()->subDays(rand(1, 20)),
                ]);
            }
        }

        // ==========================================
        // LEARNING LOGS - 20 entri aktivitas belajar
        // ==========================================
        for ($i = 0; $i < 20; $i++) {
            LearningLog::create([
                'user_id'          => $user->id,
                'roadmap_id'       => $r1->id,
                'stage_id'         => $stageIds1[array_rand($stageIds1)],
                'duration_minutes' => rand(15, 45),
                'log_date'         => now()->subDays(rand(0, 27))->toDateString(),
                'activity'         => ['study', 'review'][rand(0, 1)],
            ]);
        }
    }
}