<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Stage;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $stages = Stage::all()->keyBy('title');

        $quizData = [

            // ==========================================
            // ROADMAP 1 - Pengenalan Jaringan (id 1-4)
            // ==========================================

            'Pengertian dan Jenis Jaringan Komputer' => [
                'title'         => 'Kuis: Pengertian dan Jenis Jaringan Komputer',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Apa yang dimaksud dengan jaringan komputer?',
                        'option_a'       => 'Sekumpulan komputer yang berdiri sendiri tanpa koneksi',
                        'option_b'       => 'Dua atau lebih perangkat yang saling terhubung untuk berbagi data dan sumber daya',
                        'option_c'       => 'Satu komputer dengan banyak monitor',
                        'option_d'       => 'Perangkat keras yang digunakan untuk menyimpan data',
                        'correct_answer' => 'b',
                        'explanation'    => 'Jaringan komputer adalah kumpulan dua atau lebih perangkat yang terhubung untuk berbagi data, informasi, dan sumber daya.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Jaringan yang mencakup area dalam satu gedung atau kampus kecil disebut...',
                        'option_a'       => 'WAN',
                        'option_b'       => 'MAN',
                        'option_c'       => 'LAN',
                        'option_d'       => 'Internet',
                        'correct_answer' => 'c',
                        'explanation'    => 'LAN (Local Area Network) adalah jaringan yang mencakup area terbatas seperti satu gedung, rumah, atau kampus kecil.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'MAN (Metropolitan Area Network) biasanya mencakup area...',
                        'option_a'       => 'Satu ruangan',
                        'option_b'       => 'Satu kota atau wilayah metropolitan',
                        'option_c'       => 'Seluruh negara',
                        'option_d'       => 'Seluruh dunia',
                        'correct_answer' => 'b',
                        'explanation'    => 'MAN mencakup area satu kota atau wilayah metropolitan, lebih luas dari LAN namun lebih kecil dari WAN.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Internet merupakan contoh dari jenis jaringan...',
                        'option_a'       => 'LAN',
                        'option_b'       => 'MAN',
                        'option_c'       => 'WAN',
                        'option_d'       => 'PAN',
                        'correct_answer' => 'c',
                        'explanation'    => 'Internet adalah contoh WAN (Wide Area Network) terbesar yang menghubungkan jaringan di seluruh dunia.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Jaringan yang menghubungkan beberapa kantor cabang perusahaan di berbagai kota termasuk jenis...',
                        'option_a'       => 'LAN',
                        'option_b'       => 'PAN',
                        'option_c'       => 'MAN',
                        'option_d'       => 'WAN',
                        'correct_answer' => 'd',
                        'explanation'    => 'Menghubungkan kantor di berbagai kota yang berjauhan termasuk WAN karena mencakup area geografis yang sangat luas.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Topologi Jaringan' => [
                'title'         => 'Kuis: Topologi Jaringan',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Pada topologi star, semua perangkat terhubung ke...',
                        'option_a'       => 'Satu sama lain secara langsung',
                        'option_b'       => 'Satu perangkat pusat seperti switch atau hub',
                        'option_c'       => 'Kabel utama yang memanjang',
                        'option_d'       => 'Perangkat berikutnya membentuk lingkaran',
                        'correct_answer' => 'b',
                        'explanation'    => 'Topologi star menghubungkan semua perangkat ke satu perangkat pusat. Jika pusat rusak, seluruh jaringan terganggu.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Kelemahan utama topologi bus adalah...',
                        'option_a'       => 'Membutuhkan banyak kabel',
                        'option_b'       => 'Jika kabel utama putus, seluruh jaringan mati',
                        'option_c'       => 'Sangat mahal untuk dipasang',
                        'option_d'       => 'Tidak bisa menambah perangkat baru',
                        'correct_answer' => 'b',
                        'explanation'    => 'Kelemahan topologi bus adalah jika kabel backbone putus, semua komputer tidak dapat berkomunikasi.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Topologi ring mengirimkan data dengan cara...',
                        'option_a'       => 'Broadcast ke semua perangkat sekaligus',
                        'option_b'       => 'Langsung dari pengirim ke penerima',
                        'option_c'       => 'Melewati setiap perangkat secara berurutan membentuk lingkaran',
                        'option_d'       => 'Melalui perangkat pusat terlebih dahulu',
                        'correct_answer' => 'c',
                        'explanation'    => 'Pada topologi ring, data dikirim searah melewati setiap node secara berurutan hingga sampai ke tujuan.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Topologi mana yang paling mahal namun paling andal karena setiap perangkat terhubung ke semua perangkat lain?',
                        'option_a'       => 'Bus',
                        'option_b'       => 'Star',
                        'option_c'       => 'Ring',
                        'option_d'       => 'Mesh',
                        'correct_answer' => 'd',
                        'explanation'    => 'Topologi mesh menghubungkan setiap perangkat ke semua perangkat lain. Sangat andal karena banyak jalur alternatif, namun biaya kabel sangat mahal.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Topologi yang paling banyak digunakan di jaringan sekolah dan kantor adalah...',
                        'option_a'       => 'Bus',
                        'option_b'       => 'Ring',
                        'option_c'       => 'Star',
                        'option_d'       => 'Mesh',
                        'correct_answer' => 'c',
                        'explanation'    => 'Topologi star paling populer karena mudah dipasang, mudah troubleshooting, dan jika satu kabel putus hanya satu perangkat yang terganggu.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Pengenalan Perangkat Jaringan' => [
                'title'         => 'Kuis: Pengenalan Perangkat Jaringan',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Perangkat yang berfungsi menghubungkan dua jaringan berbeda dan menentukan jalur terbaik untuk pengiriman data adalah...',
                        'option_a'       => 'Hub',
                        'option_b'       => 'Switch',
                        'option_c'       => 'Router',
                        'option_d'       => 'Repeater',
                        'correct_answer' => 'c',
                        'explanation'    => 'Router bekerja di layer 3 (Network) dan bertugas menghubungkan jaringan berbeda serta menentukan jalur terbaik menggunakan routing table.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Perbedaan utama switch dan hub adalah...',
                        'option_a'       => 'Switch lebih murah dari hub',
                        'option_b'       => 'Switch mengirim data hanya ke perangkat tujuan, hub mengirim ke semua port',
                        'option_c'       => 'Hub lebih cepat dari switch',
                        'option_d'       => 'Switch tidak bisa menghubungkan banyak perangkat',
                        'correct_answer' => 'b',
                        'explanation'    => 'Switch lebih cerdas dari hub karena mengirim data hanya ke port tujuan berdasarkan MAC address, sehingga lebih efisien dan aman.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Perangkat yang memungkinkan perangkat nirkabel terhubung ke jaringan kabel disebut...',
                        'option_a'       => 'Modem',
                        'option_b'       => 'Switch',
                        'option_c'       => 'Access Point',
                        'option_d'       => 'Router',
                        'correct_answer' => 'c',
                        'explanation'    => 'Access Point (AP) berfungsi sebagai jembatan antara jaringan nirkabel (wireless) dengan jaringan kabel (wired).',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Modem berfungsi untuk...',
                        'option_a'       => 'Menghubungkan dua LAN yang berbeda',
                        'option_b'       => 'Mengubah sinyal digital menjadi analog dan sebaliknya untuk transmisi data',
                        'option_c'       => 'Membagi jaringan menjadi beberapa VLAN',
                        'option_d'       => 'Memperkuat sinyal jaringan yang melemah',
                        'correct_answer' => 'b',
                        'explanation'    => 'Modem (Modulator-Demodulator) mengubah sinyal digital dari komputer menjadi sinyal analog untuk dikirim, dan sebaliknya.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Perangkat yang bekerja di layer Physical OSI dan hanya memperkuat sinyal tanpa memproses data disebut...',
                        'option_a'       => 'Switch',
                        'option_b'       => 'Router',
                        'option_c'       => 'Repeater',
                        'option_d'       => 'Bridge',
                        'correct_answer' => 'c',
                        'explanation'    => 'Repeater bekerja di Layer 1 (Physical) dan hanya bertugas memperkuat sinyal yang melemah agar bisa menjangkau jarak lebih jauh.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Fungsi dan Cara Kerja Perangkat Jaringan' => [
                'title'         => 'Kuis: Fungsi dan Cara Kerja Perangkat Jaringan',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Router menentukan jalur pengiriman data menggunakan...',
                        'option_a'       => 'MAC Address Table',
                        'option_b'       => 'Routing Table',
                        'option_c'       => 'ARP Cache',
                        'option_d'       => 'DNS Record',
                        'correct_answer' => 'b',
                        'explanation'    => 'Router menggunakan routing table yang berisi informasi jaringan tujuan dan jalur terbaik untuk menentukan ke mana paket data harus dikirim.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Switch mempelajari alamat MAC perangkat melalui proses...',
                        'option_a'       => 'Routing',
                        'option_b'       => 'Broadcasting ke semua port lalu mencatat sumber',
                        'option_c'       => 'Meminta informasi ke DNS server',
                        'option_d'       => 'Membaca konfigurasi manual dari admin',
                        'correct_answer' => 'b',
                        'explanation'    => 'Switch mempelajari MAC address dengan mencatat alamat sumber dari setiap frame yang masuk, lalu menyimpannya di MAC address table.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Ketika switch menerima frame dengan MAC address tujuan yang belum dikenal, switch akan...',
                        'option_a'       => 'Membuang frame tersebut',
                        'option_b'       => 'Mengirim frame hanya ke port tertentu',
                        'option_c'       => 'Mem-broadcast frame ke semua port kecuali port asal',
                        'option_d'       => 'Mengirim ke router untuk diproses',
                        'correct_answer' => 'c',
                        'explanation'    => 'Jika MAC address tujuan tidak ada di tabel, switch akan mem-flood (broadcast) frame ke semua port kecuali port yang menerima frame tersebut.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Access point yang terhubung ke router via kabel dan memancarkan sinyal Wi-Fi berfungsi sebagai...',
                        'option_a'       => 'Gateway',
                        'option_b'       => 'Bridge antara jaringan wired dan wireless',
                        'option_c'       => 'Firewall jaringan',
                        'option_d'       => 'DHCP server utama',
                        'correct_answer' => 'b',
                        'explanation'    => 'Access point berfungsi sebagai bridge yang menghubungkan perangkat wireless ke jaringan kabel, meneruskan data antara kedua media transmisi.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Pada jaringan rumah, perangkat yang biasanya bertindak sebagai DHCP server untuk memberi IP otomatis adalah...',
                        'option_a'       => 'Switch',
                        'option_b'       => 'Access Point',
                        'option_c'       => 'Router',
                        'option_d'       => 'Modem',
                        'correct_answer' => 'c',
                        'explanation'    => 'Router pada jaringan rumah biasanya sudah dilengkapi fitur DHCP server yang secara otomatis memberikan IP address ke setiap perangkat yang terhubung.',
                        'order'          => 5,
                    ],
                ],
            ],

            // ==========================================
            // ROADMAP 2 - Konsep Jaringan (id 5-13)
            // ==========================================

            'IPv4 & IPv6' => [
                'title'         => 'Kuis: IPv4 & IPv6',
                'passing_score' => 60,
                'points_reward' => 15,
                'questions' => [
                    [
                        'question'       => 'Berapa panjang bit yang digunakan oleh IPv4?',
                        'option_a'       => '16 bit',
                        'option_b'       => '32 bit',
                        'option_c'       => '64 bit',
                        'option_d'       => '128 bit',
                        'correct_answer' => 'b',
                        'explanation'    => 'IPv4 menggunakan 32 bit yang dibagi menjadi 4 oktet (masing-masing 8 bit), menghasilkan sekitar 4,3 miliar alamat unik.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Berapa panjang bit yang digunakan oleh IPv6?',
                        'option_a'       => '32 bit',
                        'option_b'       => '64 bit',
                        'option_c'       => '128 bit',
                        'option_d'       => '256 bit',
                        'correct_answer' => 'c',
                        'explanation'    => 'IPv6 menggunakan 128 bit, menghasilkan jumlah alamat yang sangat besar (sekitar 3,4 × 10^38 alamat) untuk mengatasi keterbatasan IPv4.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Manakah yang merupakan IP Address Private pada IPv4?',
                        'option_a'       => '8.8.8.8',
                        'option_b'       => '192.168.1.1',
                        'option_c'       => '103.21.244.0',
                        'option_d'       => '172.217.0.0',
                        'correct_answer' => 'b',
                        'explanation'    => '192.168.x.x adalah range IP private kelas C yang hanya digunakan di jaringan lokal dan tidak bisa diakses langsung dari internet.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Alasan utama pengembangan IPv6 adalah...',
                        'option_a'       => 'IPv4 terlalu cepat',
                        'option_b'       => 'Keterbatasan jumlah alamat IPv4 yang hampir habis',
                        'option_c'       => 'IPv4 tidak aman',
                        'option_d'       => 'IPv6 lebih mudah diingat',
                        'correct_answer' => 'b',
                        'explanation'    => 'IPv6 dikembangkan terutama karena alamat IPv4 (32 bit) hampir habis seiring dengan pertumbuhan perangkat yang terhubung ke internet.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Format penulisan IPv6 yang benar adalah...',
                        'option_a'       => '4 kelompok angka desimal dipisah titik',
                        'option_b'       => '8 kelompok 4 digit heksadesimal dipisah titik dua (:)',
                        'option_c'       => '6 kelompok angka biner dipisah strip',
                        'option_d'       => '4 kelompok angka oktal dipisah koma',
                        'correct_answer' => 'b',
                        'explanation'    => 'IPv6 ditulis dalam 8 kelompok yang masing-masing terdiri dari 4 digit heksadesimal, dipisahkan oleh titik dua. Contoh: 2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                        'order'          => 5,
                    ],
                ],
            ],

            'TCP/IP Model' => [
                'title'         => 'Kuis: TCP/IP Model',
                'passing_score' => 60,
                'points_reward' => 15,
                'questions' => [
                    [
                        'question'       => 'Berapa jumlah lapisan pada model TCP/IP?',
                        'option_a'       => '3 lapisan',
                        'option_b'       => '4 lapisan',
                        'option_c'       => '5 lapisan',
                        'option_d'       => '7 lapisan',
                        'correct_answer' => 'b',
                        'explanation'    => 'Model TCP/IP terdiri dari 4 lapisan: Network Access, Internet, Transport, dan Application.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Lapisan Internet pada TCP/IP setara dengan lapisan apa pada OSI?',
                        'option_a'       => 'Data Link Layer',
                        'option_b'       => 'Network Layer',
                        'option_c'       => 'Transport Layer',
                        'option_d'       => 'Session Layer',
                        'correct_answer' => 'b',
                        'explanation'    => 'Lapisan Internet pada TCP/IP setara dengan Network Layer (Layer 3) pada OSI, keduanya bertanggung jawab atas pengalamatan IP dan routing.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Protokol TCP memberikan layanan pengiriman data yang bersifat...',
                        'option_a'       => 'Connectionless dan tidak andal',
                        'option_b'       => 'Connection-oriented dan andal',
                        'option_c'       => 'Broadcast ke semua perangkat',
                        'option_d'       => 'Hanya untuk jaringan lokal',
                        'correct_answer' => 'b',
                        'explanation'    => 'TCP (Transmission Control Protocol) bersifat connection-oriented, artinya ada proses handshake sebelum data dikirim, dan menjamin data sampai dengan benar.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Perbedaan utama TCP dan UDP adalah...',
                        'option_a'       => 'TCP lebih cepat dari UDP',
                        'option_b'       => 'UDP menjamin pengiriman data, TCP tidak',
                        'option_c'       => 'TCP menjamin pengiriman data, UDP tidak',
                        'option_d'       => 'UDP hanya untuk jaringan lokal',
                        'correct_answer' => 'c',
                        'explanation'    => 'TCP menjamin data sampai dengan urutan yang benar (reliable), sedangkan UDP lebih cepat namun tidak menjamin pengiriman (unreliable). UDP cocok untuk streaming dan game.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'HTTP dan HTTPS bekerja pada lapisan apa di model TCP/IP?',
                        'option_a'       => 'Network Access',
                        'option_b'       => 'Internet',
                        'option_c'       => 'Transport',
                        'option_d'       => 'Application',
                        'correct_answer' => 'd',
                        'explanation'    => 'HTTP dan HTTPS adalah protokol aplikasi yang bekerja di Application Layer, lapisan tertinggi pada model TCP/IP.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Networking Service' => [
                'title'         => 'Kuis: Networking Service',
                'passing_score' => 60,
                'points_reward' => 15,
                'questions' => [
                    [
                        'question'       => 'DNS (Domain Name System) berfungsi untuk...',
                        'option_a'       => 'Memberikan IP address otomatis ke perangkat',
                        'option_b'       => 'Menerjemahkan nama domain menjadi IP address',
                        'option_c'       => 'Mengamankan koneksi jaringan',
                        'option_d'       => 'Menghubungkan dua jaringan yang berbeda',
                        'correct_answer' => 'b',
                        'explanation'    => 'DNS menerjemahkan nama domain yang mudah diingat manusia (seperti google.com) menjadi IP address yang dimengerti komputer (seperti 142.250.74.46).',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'DHCP (Dynamic Host Configuration Protocol) digunakan untuk...',
                        'option_a'       => 'Mengenkripsi data yang dikirim',
                        'option_b'       => 'Menerjemahkan domain ke IP address',
                        'option_c'       => 'Memberikan IP address secara otomatis ke perangkat dalam jaringan',
                        'option_d'       => 'Memblokir akses ke situs berbahaya',
                        'correct_answer' => 'c',
                        'explanation'    => 'DHCP secara otomatis memberikan IP address, subnet mask, gateway, dan DNS server ke setiap perangkat yang terhubung ke jaringan.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Port default yang digunakan oleh protokol HTTP adalah...',
                        'option_a'       => 'Port 21',
                        'option_b'       => 'Port 25',
                        'option_c'       => 'Port 80',
                        'option_d'       => 'Port 443',
                        'correct_answer' => 'c',
                        'explanation'    => 'HTTP menggunakan port 80 secara default, sedangkan HTTPS menggunakan port 443 untuk koneksi yang terenkripsi.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Protokol yang digunakan untuk mengirim email adalah...',
                        'option_a'       => 'FTP',
                        'option_b'       => 'SMTP',
                        'option_c'       => 'HTTP',
                        'option_d'       => 'SSH',
                        'correct_answer' => 'b',
                        'explanation'    => 'SMTP (Simple Mail Transfer Protocol) digunakan untuk mengirim email dari client ke server atau antar server email, menggunakan port 25 atau 587.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Protokol yang digunakan untuk transfer file secara aman menggunakan enkripsi adalah...',
                        'option_a'       => 'FTP',
                        'option_b'       => 'HTTP',
                        'option_c'       => 'SFTP',
                        'option_d'       => 'SMTP',
                        'correct_answer' => 'c',
                        'explanation'    => 'SFTP (SSH File Transfer Protocol) adalah versi aman dari FTP yang menggunakan enkripsi SSH untuk melindungi data yang ditransfer.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Keamanan Jaringan Telekomunikasi' => [
                'title'         => 'Kuis: Keamanan Jaringan Telekomunikasi',
                'passing_score' => 60,
                'points_reward' => 15,
                'questions' => [
                    [
                        'question'       => 'Tiga prinsip utama keamanan informasi yang dikenal sebagai CIA Triad adalah...',
                        'option_a'       => 'Confidentiality, Integrity, Availability',
                        'option_b'       => 'Control, Identification, Authentication',
                        'option_c'       => 'Cryptography, Intrusion, Access',
                        'option_d'       => 'Certificate, Identity, Authorization',
                        'correct_answer' => 'a',
                        'explanation'    => 'CIA Triad adalah tiga prinsip keamanan: Confidentiality (kerahasiaan), Integrity (integritas data), dan Availability (ketersediaan layanan).',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Firewall pada jaringan berfungsi untuk...',
                        'option_a'       => 'Mempercepat koneksi internet',
                        'option_b'       => 'Memfilter dan mengontrol lalu lintas jaringan berdasarkan aturan keamanan',
                        'option_c'       => 'Memberikan IP address otomatis',
                        'option_d'       => 'Menerjemahkan nama domain ke IP address',
                        'correct_answer' => 'b',
                        'explanation'    => 'Firewall memfilter paket data yang masuk dan keluar jaringan berdasarkan aturan yang ditentukan, memblokir traffic yang tidak diizinkan.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Serangan yang mencoba membuat layanan tidak tersedia dengan membanjiri server dengan request berlebihan disebut...',
                        'option_a'       => 'Phishing',
                        'option_b'       => 'Man in the Middle',
                        'option_c'       => 'DoS (Denial of Service)',
                        'option_d'       => 'SQL Injection',
                        'correct_answer' => 'c',
                        'explanation'    => 'DoS attack membanjiri server dengan traffic berlebihan sehingga server tidak dapat melayani pengguna yang sah. DDoS adalah versi terdistribusinya.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Teknik menipu pengguna agar memberikan informasi sensitif dengan berpura-pura menjadi pihak terpercaya disebut...',
                        'option_a'       => 'Malware',
                        'option_b'       => 'Phishing',
                        'option_c'       => 'Brute Force',
                        'option_d'       => 'Spoofing',
                        'correct_answer' => 'b',
                        'explanation'    => 'Phishing adalah teknik social engineering yang menipu korban melalui email, website, atau pesan palsu yang menyerupai entitas terpercaya.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'VPN (Virtual Private Network) digunakan untuk...',
                        'option_a'       => 'Mempercepat akses internet',
                        'option_b'       => 'Membuat koneksi terenkripsi yang aman melalui jaringan publik',
                        'option_c'       => 'Memblokir iklan di browser',
                        'option_d'       => 'Menghubungkan dua switch dalam satu gedung',
                        'correct_answer' => 'b',
                        'explanation'    => 'VPN membuat tunnel terenkripsi melalui internet publik, memungkinkan komunikasi yang aman seolah-olah berada dalam jaringan privat.',
                        'order'          => 5,
                    ],
                ],
            ],

            // ==========================================
            // ROADMAP 3 - Proses Bisnis & Teknologi (id 14-19)
            // ==========================================

            'Proses Bisnis di Bidang Jaringan' => [
                'title'         => 'Kuis: Proses Bisnis di Bidang Jaringan',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Dokumen yang berisi catatan lengkap tentang konfigurasi dan topologi jaringan perusahaan disebut...',
                        'option_a'       => 'SLA (Service Level Agreement)',
                        'option_b'       => 'Network Documentation',
                        'option_c'       => 'Patch Management',
                        'option_d'       => 'Change Request',
                        'correct_answer' => 'b',
                        'explanation'    => 'Network Documentation berisi semua informasi penting tentang jaringan termasuk topologi, konfigurasi perangkat, IP address, dan diagram jaringan.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'SLA (Service Level Agreement) dalam konteks jaringan adalah...',
                        'option_a'       => 'Perangkat lunak untuk monitoring jaringan',
                        'option_b'       => 'Perjanjian antara penyedia layanan dan pelanggan tentang standar layanan',
                        'option_c'       => 'Protokol keamanan jaringan',
                        'option_d'       => 'Alat untuk mengkonfigurasi router',
                        'correct_answer' => 'b',
                        'explanation'    => 'SLA adalah kontrak yang mendefinisikan standar layanan yang harus dipenuhi penyedia jasa, termasuk uptime, response time, dan resolusi masalah.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Tahapan pertama yang dilakukan teknisi jaringan saat menerima laporan gangguan adalah...',
                        'option_a'       => 'Langsung mengganti perangkat keras',
                        'option_b'       => 'Mengidentifikasi dan mendokumentasikan masalah',
                        'option_c'       => 'Menghubungi vendor perangkat',
                        'option_d'       => 'Mematikan seluruh jaringan',
                        'correct_answer' => 'b',
                        'explanation'    => 'Langkah pertama troubleshooting adalah mengidentifikasi masalah secara sistematis, mengumpulkan informasi, dan mendokumentasikan gejala yang dilaporkan.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Alur kerja teknisi jaringan yang benar saat instalasi jaringan baru adalah...',
                        'option_a'       => 'Instalasi → Perencanaan → Pengujian → Dokumentasi',
                        'option_b'       => 'Perencanaan → Instalasi → Pengujian → Dokumentasi',
                        'option_c'       => 'Dokumentasi → Instalasi → Perencanaan → Pengujian',
                        'option_d'       => 'Pengujian → Perencanaan → Dokumentasi → Instalasi',
                        'correct_answer' => 'b',
                        'explanation'    => 'Alur yang benar: Perencanaan (desain jaringan) → Instalasi (pasang perangkat) → Pengujian (verifikasi koneksi) → Dokumentasi (catat konfigurasi).',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Sertifikasi yang paling diakui secara internasional untuk teknisi jaringan tingkat dasar adalah...',
                        'option_a'       => 'Microsoft Office Specialist',
                        'option_b'       => 'Cisco CCNA',
                        'option_c'       => 'Adobe Certified Expert',
                        'option_d'       => 'CompTIA A+',
                        'correct_answer' => 'b',
                        'explanation'    => 'Cisco CCNA (Cisco Certified Network Associate) adalah sertifikasi jaringan tingkat asosiasi yang paling diakui dan dicari di industri jaringan komputer.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Cloud Computing' => [
                'title'         => 'Kuis: Cloud Computing',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Yang dimaksud dengan Cloud Computing adalah...',
                        'option_a'       => 'Komputer yang dipasang di awan',
                        'option_b'       => 'Layanan komputasi yang disediakan melalui internet secara on-demand',
                        'option_c'       => 'Jaringan nirkabel generasi terbaru',
                        'option_d'       => 'Software untuk manajemen jaringan',
                        'correct_answer' => 'b',
                        'explanation'    => 'Cloud computing adalah model layanan yang menyediakan sumber daya komputasi (server, storage, aplikasi) melalui internet secara on-demand dan berbasis langganan.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Model layanan cloud yang menyediakan infrastruktur seperti virtual machine dan storage disebut...',
                        'option_a'       => 'SaaS',
                        'option_b'       => 'PaaS',
                        'option_c'       => 'IaaS',
                        'option_d'       => 'DaaS',
                        'correct_answer' => 'c',
                        'explanation'    => 'IaaS (Infrastructure as a Service) menyediakan infrastruktur dasar seperti virtual machine, storage, dan networking. Contoh: AWS EC2, Google Compute Engine.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Google Workspace (Docs, Sheets, Gmail) merupakan contoh dari model layanan cloud...',
                        'option_a'       => 'IaaS',
                        'option_b'       => 'PaaS',
                        'option_c'       => 'SaaS',
                        'option_d'       => 'NaaS',
                        'correct_answer' => 'c',
                        'explanation'    => 'SaaS (Software as a Service) menyediakan aplikasi siap pakai melalui internet. Pengguna tidak perlu install software, cukup akses lewat browser.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Keunggulan utama cloud computing dibandingkan infrastruktur on-premise adalah...',
                        'option_a'       => 'Lebih mahal namun lebih aman',
                        'option_b'       => 'Skalabilitas fleksibel dan hemat biaya investasi awal',
                        'option_c'       => 'Tidak memerlukan koneksi internet',
                        'option_d'       => 'Data selalu tersimpan di komputer lokal',
                        'correct_answer' => 'b',
                        'explanation'    => 'Cloud computing memungkinkan skalabilitas fleksibel (scale up/down sesuai kebutuhan) dan mengurangi biaya investasi awal karena model pay-as-you-go.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Penyedia layanan cloud terbesar di dunia saat ini adalah...',
                        'option_a'       => 'IBM dan Oracle',
                        'option_b'       => 'AWS, Microsoft Azure, dan Google Cloud',
                        'option_c'       => 'Cisco dan Juniper',
                        'option_d'       => 'Samsung dan Sony',
                        'correct_answer' => 'b',
                        'explanation'    => 'Tiga penyedia cloud terbesar (hyperscaler) adalah Amazon Web Services (AWS), Microsoft Azure, dan Google Cloud Platform yang menguasai mayoritas pasar cloud global.',
                        'order'          => 5,
                    ],
                ],
            ],

            'Internet of Things (IoT)' => [
                'title'         => 'Kuis: Internet of Things (IoT)',
                'passing_score' => 60,
                'points_reward' => 10,
                'questions' => [
                    [
                        'question'       => 'Internet of Things (IoT) adalah konsep dimana...',
                        'option_a'       => 'Internet hanya dapat diakses melalui komputer',
                        'option_b'       => 'Perangkat fisik sehari-hari terhubung ke internet dan dapat saling berkomunikasi',
                        'option_c'       => 'Jaringan internet yang sangat cepat',
                        'option_d'       => 'Sistem operasi untuk perangkat mobile',
                        'correct_answer' => 'b',
                        'explanation'    => 'IoT adalah ekosistem perangkat fisik (sensor, aktuator, peralatan rumah tangga) yang terhubung ke internet untuk mengumpulkan dan berbagi data secara otomatis.',
                        'order'          => 1,
                    ],
                    [
                        'question'       => 'Contoh implementasi IoT dalam kehidupan sehari-hari adalah...',
                        'option_a'       => 'Menggunakan laptop untuk mengetik',
                        'option_b'       => 'Smart home dengan lampu dan AC yang bisa dikontrol via smartphone',
                        'option_c'       => 'Mencetak dokumen dengan printer',
                        'option_d'       => 'Menonton video di YouTube',
                        'correct_answer' => 'b',
                        'explanation'    => 'Smart home adalah contoh IoT dimana perangkat seperti lampu, AC, kunci pintu, dan CCTV terhubung ke internet dan bisa dikontrol dari smartphone.',
                        'order'          => 2,
                    ],
                    [
                        'question'       => 'Protokol komunikasi yang ringan dan sering digunakan pada perangkat IoT adalah...',
                        'option_a'       => 'HTTP',
                        'option_b'       => 'FTP',
                        'option_c'       => 'MQTT',
                        'option_d'       => 'SMTP',
                        'correct_answer' => 'c',
                        'explanation'    => 'MQTT (Message Queuing Telemetry Transport) adalah protokol messaging ringan yang dirancang untuk perangkat IoT dengan bandwidth terbatas dan konsumsi daya rendah.',
                        'order'          => 3,
                    ],
                    [
                        'question'       => 'Tantangan keamanan utama pada perangkat IoT adalah...',
                        'option_a'       => 'Terlalu banyak fitur yang tidak diperlukan',
                        'option_b'       => 'Banyak perangkat IoT memiliki keamanan lemah dan sulit diupdate',
                        'option_c'       => 'Perangkat IoT terlalu mahal',
                        'option_d'       => 'Tidak bisa terhubung ke jaringan Wi-Fi',
                        'correct_answer' => 'b',
                        'explanation'    => 'Banyak perangkat IoT memiliki resources terbatas sehingga sulit mengimplementasikan keamanan yang kuat, dan sering tidak mendapat update firmware secara rutin.',
                        'order'          => 4,
                    ],
                    [
                        'question'       => 'Dalam arsitektur IoT, komponen yang bertugas mengumpulkan data dari lingkungan fisik adalah...',
                        'option_a'       => 'Cloud server',
                        'option_b'       => 'Mobile application',
                        'option_c'       => 'Sensor',
                        'option_d'       => 'Database',
                        'correct_answer' => 'c',
                        'explanation'    => 'Sensor adalah komponen IoT yang mendeteksi dan mengukur kondisi fisik seperti suhu, kelembaban, cahaya, atau gerakan, lalu mengubahnya menjadi data digital.',
                        'order'          => 5,
                    ],
                ],
            ],
        ];

        // ==========================================
        // Buat quiz dan soal
        // ==========================================
        foreach ($quizData as $stageTitle => $data) {
            $stage = $stages->get($stageTitle);

            if (!$stage) {
                $this->command->warn("Stage tidak ditemukan: {$stageTitle}");
                continue;
            }

            if ($stage->quiz) {
                $stage->quiz->questions()->delete();
                $stage->quiz->delete();
            }

            $quiz = Quiz::create([
                'stage_id'      => $stage->id,
                'title'         => $data['title'],
                'passing_score' => $data['passing_score'],
                'points_reward' => $data['points_reward'],
            ]);

            foreach ($data['questions'] as $q) {
                QuizQuestion::create([
                    'quiz_id'        => $quiz->id,
                    'question'       => $q['question'],
                    'option_a'       => $q['option_a'],
                    'option_b'       => $q['option_b'],
                    'option_c'       => $q['option_c'],
                    'option_d'       => $q['option_d'],
                    'correct_answer' => $q['correct_answer'],
                    'explanation'    => $q['explanation'],
                    'order'          => $q['order'],
                ]);
            }

            $this->command->info("✓ Quiz dibuat untuk stage: {$stageTitle} ({$quiz->questions()->count()} soal)");
        }
    }
}