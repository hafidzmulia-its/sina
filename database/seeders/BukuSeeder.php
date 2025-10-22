<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
   

        $bukus = [
            [
                'jenis' => 'Fabel',
                'judul' => 'Kura-kura dan Kelinci',
                'cover' => 'images/tortoise_hare.png',
                'sinopsis' => 'Kelinci yang angkuh sering mengejek Kura-kura karena jalannya yang sangat pelan. Merasa diremehkan, Kura-kura pun menantang Kelinci untuk lomba lari. Kelinci menerima tantangan tersebut dengan tawa dan keyakinan mutlak bahwa ia akan menang.Saat lomba dimulai, Kelinci dengan mudah melesat jauh meninggalkan Kura-kura di belakang. Merasa bahwa Kura-kura tidak akan pernah bisa menyusulnya, Kelinci menjadi terlalu percaya diri dan memutuskan untuk beristirahat dan tidur siang di bawah pohon rindang yang terletak di tengah lintasan.Ingin tahu kelanjutan kisahnya? Mari membaca!'
            ],
            [
                'jenis' => 'Fabel',
                'judul' => 'Semut dan Belalang',
                'cover' => 'images/theant.png',
                'sinopsis' => 'Kisah ini berlatar pada dua musim: panas dan dingin. Selama musim panas, Semut bekerja keras sepanjang hari, mengumpulkan dan menyimpan makanan sebagai bekal untuk musim dingin. Sementara itu, Belalang yang riang menghabiskan waktunya dengan bersantai, bermain musik, dan bernyanyi, serta menertawakan kerja keras Semut. Ketika musim dingin tiba, Semut hidup nyaman di sarangnya dengan persediaan makanan melimpah. Belalang, yang tidak punya persediaan apa pun, mulai kelaparan dan kedinginan. Ia memohon bantuan kepada Semut, tetapi Semut menolaknya, mengajarkan bahwa waktu untuk bekerja adalah saat ada kesempatan.'
            ],
            [
                'jenis' => 'Fabel',
                'judul' => 'Serigala Berbulu Domba',
                'cover' => 'images/wolf_sheep.png',
                'sinopsis' => 'Seekor Serigala yang lapar selalu kesulitan mendekati kawanan domba karena dijaga ketat oleh penggembala dan anjing. Serigala mendapat ide licik: ia mencuri kulit Domba dan menyamar dengan mengenakannya. Berkat penyamaran tersebut, Serigala berhasil menyusup ke tengah kawanan domba tanpa dicurigai. Namun, pada malam hari, sang penggembala datang untuk memilih domba yang akan disembelih untuk hidangan. Tanpa sengaja, ia memilih Domba yang sebenarnya adalah Serigala yang menyamar.'
            ],
            [
                'jenis' => 'Fabel',
                'judul' => 'Gagak yang Cerdik',
                'cover' => 'images/thefox.png',
                'sinopsis' => 'Pada suatu hari yang sangat panas, seekor Gagak merasa haus luar biasa. Setelah terbang ke sana kemari, ia menemukan sebuah teko yang berisi air, tetapi airnya sangat sedikit dan berada di dasar teko, terlalu rendah untuk dijangkau paruhnya. Daripada menyerah, Gagak berpikir keras. Ia mendapat ide dan mulai mengumpulkan kerikil kecil. Gagak menjatuhkan kerikil-kerikil itu satu per satu ke dalam teko. Perlahan, volume kerikil membuat permukaan air naik, hingga akhirnya mencapai jangkauan paruh Gagak, dan ia pun bisa minum serta memuaskan dahaganya.'
            ],
            [
                'jenis' => 'Fabel',
                'judul' => 'Bebek Buruk Rupa',
                'cover' => 'images/theugly.png',
                'sinopsis' => 'Di sebuah peternakan, seekor Bebek Betina bangga ketika telurnya menetas, kecuali satu telur yang menetaskan anak Bebek dengan penampilan yang berbeda, abu-abu, dan canggung. Anak Bebek ini diejek dan disisihkan oleh semua hewan lain—bahkan oleh saudara-saudaranya sendiri—karena penampilannya yang dianggap "buruk rupa." Merasa sedih dan tidak diinginkan, Bebek buruk rupa itu melarikan diri dan hidup sendirian, menghadapi musim dingin yang keras. Ketika musim semi tiba, ia melihat sekelompok angsa cantik di kolam. Ia mendekat, bersiap diejek, namun ia melihat bayangannya sendiri di air. Ternyata, ia telah tumbuh menjadi Angsa yang sangat indah, bukan Bebek. Ia menemukan bahwa ia berbeda karena ia memang bukan Bebek; ia adalah Angsa.'
            ],
            [
                'jenis' => 'Cerita Rakyat',
                'judul' => 'Malin Kundang',
                'cover' => 'images/malin_kundang.png',
                'sinopsis' => 'Malin Kundang adalah seorang pemuda miskin dari Padang yang merantau ke negeri seberang. Berkat kerja kerasnya, ia berhasil menjadi saudagar kaya raya dan menikah dengan seorang bangsawan. Ketika ia kembali ke kampung halaman dengan kapalnya yang megah, ibunya yang sudah tua dan miskin datang menyambutnya. Karena malu dengan kemiskinan ibunya, Malin menolak mengakui wanita tua itu sebagai ibunya. Sang ibu yang sakit hati dan merasa terhina akhirnya bersumpah. Sumpah itu terkabul, dan seketika itu juga Malin Kundang bersama kapalnya berubah menjadi batu sebagai hukuman atas kedurhakaannya.'
            ],
            [
                'jenis' => 'Cerita Rakyat',
                'judul' => 'Danau Toba',
                'cover' => 'images/danau_toba.png',
                'sinopsis' => 'Alkisah, ada seorang petani bernama Toba yang miskin. Suatu hari, ia mendapatkan ikan mas yang sangat besar. Ajaibnya, ikan itu berubah menjadi seorang gadis cantik yang bersedia dinikahi Toba dengan satu syarat: Toba tidak boleh mengungkapkan kepada siapa pun bahwa ia berasal dari ikan. Toba setuju. Mereka menikah dan memiliki seorang putra bernama Samosir. Suatu hari, Samosir diperintahkan ibunya mengantar makanan ke ladang, tetapi ia memakan sebagian makanan itu. Toba yang marah memukul Samosir sambil mengucapkan kata-kata terlarang: "Dasar anak ikan!" Seketika itu juga, langit gelap, hujan deras turun, dan istri serta anaknya menghilang. Bekas galian air yang meluap dari sumur itu membentuk sebuah danau besar yang kini dikenal sebagai Danau Toba, dengan Pulau Samosir di tengahnya.'
            ],
            [
                'jenis' => 'Cerita Rakyat',
                'judul' => 'Legenda Gunung Tangkuban Parahu',
                'cover' => 'images/tangkuban_parahu.png',
                'sinopsis' => 'Dayang Sumbi adalah putri cantik yang dikutuk awet muda. Ia memiliki putra bernama Sangkuriang. Karena suatu kesalahpahaman, Sangkuriang diusir dari rumah dan tumbuh dewasa tanpa mengetahui siapa ibunya. Ketika Sangkuriang dewasa dan berkelana, ia bertemu kembali dengan Dayang Sumbi dan jatuh cinta padanya tanpa menyadari bahwa itu adalah ibunya sendiri. Dayang Sumbi, yang mengenali bekas luka di kepala Sangkuriang, menolak menikah. Untuk menggagalkan pernikahan itu, ia memberi syarat mustahil: membuat danau dan perahu dalam satu malam. Sangkuriang yang sakti hampir berhasil menyelesaikan tugasnya. Dayang Sumbi panik dan memutuskan untuk membuat fajar palsu. Merasa dicurangi, Sangkuriang marah besar dan menendang perahu yang hampir jadi itu, membuat perahu terbalik dan kini dikenal sebagai Gunung Tangkuban Parahu.'
            ],
            [
                'jenis' => 'Cerita Rakyat',
                'judul' => 'Bawang Merah dan Bawang Putih',
                'cover' => 'images/bawang_merah_putih.png',
                'sinopsis' => 'Bawang Putih adalah gadis yang baik hati dan rajin, namun hidup menderita setelah ayahnya meninggal. Ia tinggal bersama ibu tiri (Bawang Merah) dan saudara tiri (Bawang Putih) yang jahat dan pemalas. Bawang Putih selalu diperlakukan sebagai pembantu. Suatu hari, ia harus mencari danau tempat ia kehilangan kain milik ibu tirinya. Di sana, ia bertemu seorang nenek yang memberinya dua pilihan labu: satu kecil dan satu besar. Bawang Putih yang jujur memilih labu kecil. Ternyata, di dalamnya terdapat perhiasan emas. Bawang Merah yang serakah ingin mendapatkan hal yang sama, tetapi ia berbohong kepada nenek dan memilih labu yang besar. Ketika labu itu dibuka, isinya bukanlah emas, melainkan binatang berbisa yang menyerang Bawang Merah dan ibunya.'
            ],
            [
                'jenis' => 'Cerita Rakyat',
                'judul' => 'Jaka Tarub dan Nawangwulan',
                'cover' => 'images/jaka_tarub.png',
                'sinopsis' => 'Jaka Tarub, seorang pemuda desa, mengintip tujuh bidadari yang mandi di telaga dan mencuri selendang salah satu bidadari, Nawangwulan. Karena selendangnya hilang, Nawangwulan tidak bisa kembali ke kayangan dan akhirnya menikah dengan Jaka Tarub. Nawangwulan memiliki kesaktian di mana ia hanya perlu memasak satu butir nasi untuk kenyang, dengan syarat Jaka Tarub tidak boleh melihat proses memasaknya. Jaka Tarub melanggar larangan tersebut, dan kesaktian Nawangwulan pun hilang. Ketika padi di lumbung menipis, Nawangwulan menemukan selendangnya yang disembunyikan Jaka Tarub. Mengetahui dirinya dibohongi, Nawangwulan kembali ke kayangan, meninggalkan suaminya dan putri mereka.'
            ],
            [
                'jenis' => 'Dongeng',
                'judul' => 'Putri Salju',
                'cover' => 'images/snow_white.png',
                'sinopsis' => 'Putri Salju adalah seorang putri cantik yang memiliki ibu tiri, seorang Ratu yang jahat dan iri hati terhadap kecantikan Putri Salju. Ratu selalu bertanya pada cermin ajaibnya siapa yang paling cantik. Ketika cermin menjawab bahwa Putri Salju lebih cantik, Ratu memerintahkan untuk membunuhnya. Putri Salju melarikan diri ke hutan dan berlindung di rumah tujuh kurcaci. Ratu yang tahu Putri Salju masih hidup, menyamar menjadi nenek tua dan meracuninya dengan apel. Putri Salju tertidur lelap hingga ia dibangunkan oleh ciuman seorang Pangeran tampan.'
            ],
            [
                'jenis' => 'Dongeng',
                'judul' => 'Pinokio',
                'cover' => 'images/pinocchio.png',
                'sinopsis' => 'Pinokio adalah boneka kayu yang dibuat oleh tukang kayu tua bernama Geppetto. Pinokio ingin sekali menjadi anak laki-laki sejati. Seorang Peri Biru mengatakan ia bisa menjadi anak sejati jika ia berani, jujur, dan tidak egois. Namun, Pinokio sering berbohong dan mudah dibujuk. Setiap kali ia berbohong, hidungnya akan memanjang. Setelah melewati berbagai petualangan berbahaya dan akhirnya menunjukkan keberaniannya dalam menyelamatkan Geppetto dari perut ikan paus, Peri Biru mengabulkan keinginannya dan mengubah Pinokio menjadi anak laki-laki sejati.'
            ],
            [
                'jenis' => 'Dongeng',
                'judul' => 'Tiga Babi Kecil',
                'cover' => 'images/three_pigs.png',
                'sinopsis' => 'Tiga ekor babi kecil meninggalkan rumah untuk hidup mandiri. Babi pertama yang malas membangun rumah dari jerami. Babi kedua yang sedikit rajin membangun rumah dari kayu. Dan babi ketiga yang rajin dan tekun membangun rumah dari batu bata. Seekor Serigala besar dan jahat datang dan dengan mudah meniup roboh rumah jerami dan rumah kayu. Kedua babi yang panik berlari dan berlindung di rumah batu bata. Serigala tidak bisa merobohkan rumah batu bata itu, dan akhirnya berhasil dikalahkan.'
            ],
            [
                'jenis' => 'Dongeng',
                'judul' => 'Gadis Berkerudung Merah',
                'cover' => 'images/red_riding_hood.png',
                'sinopsis' => 'Seorang gadis kecil yang mengenakan kerudung merah pergi mengunjungi neneknya yang sedang sakit. Ibunya berpesan agar ia tidak menyimpang dari jalan setapak. Di tengah perjalanan, ia bertemu dengan Serigala jahat yang licik. Serigala itu berhasil menipu Gadis Berkerudung Merah agar mengambil jalan memutar, sementara Serigala bergegas ke rumah nenek, memakan sang Nenek, dan menyamar di tempat tidur. Ketika Gadis Berkerudung Merah tiba, Serigala berusaha memakannya. Untungnya, seorang pemburu datang tepat waktu, membunuh Serigala, dan menyelamatkan Nenek dan Gadis Berkerudung Merah.'
            ],
            [
                'jenis' => 'Dongeng',
                'judul' => 'Cinderella',
                'cover' => 'images/cinderella.png',
                'sinopsis' => 'Cinderella adalah gadis cantik yang hidup menderita setelah ayahnya meninggal. Ia diperlakukan seperti pelayan oleh ibu tiri dan dua saudara tiri perempuannya yang jahat. Suatu hari, Raja mengadakan pesta dansa untuk mencari istri bagi Pangeran. Dengan bantuan Ibu Peri, Cinderella berhasil datang ke pesta dalam gaun indah, tetapi ia harus pulang sebelum tengah malam. Saat terburu-buru, ia menjatuhkan salah satu sepatu kacanya. Pangeran yang terpesona mencari pemilik sepatu kaca itu ke seluruh negeri. Akhirnya, Pangeran menemukan Cinderella, dan setelah mencoba sepatu itu pas di kakinya, Cinderella pun menikah dengan Pangeran dan hidup bahagia selamanya.'
            ]
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}