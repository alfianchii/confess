<?php

namespace Database\Seeders;

use App\Models\RecConfessionComment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RecConfessionCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomnessOfUsers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $randomnessOfPrivacy = ["public", "anonymous"];

        RecConfessionComment::insert([
            // Confession 1
            [
                "id_confession_comment" => 1,
                "id_confession" => 1,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Gile beneran serem amat tuh, bro! Semoga loe gak kenapa-napa. Coba aja lapor ke polisi atau guru-guru di sekolah, biar mereka bisa ngecek kamera CCTV atau apa gitu.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 2,
                "id_confession" => 1,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Astaga, serem banget sih ceritanya. Kalo gue sih langsung aja lapor ke pihak berwenang, biar cepet ketangkep tuh orang. Jangan biarin kejadian kaya gitu berulang.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 3,
                "id_confession" => 1,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Wah parah banget, tuh! Langsung aja ke guru atau kepsek, bilangin kejadian lo. Mungkin mereka bisa ambil langkah buat ngejaga keamanan di sekolah.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 4,
                "id_confession" => 1,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Langsung lapor aja ke yang berwenang, biar mereka bisa tindak cepet. Semoga loe aman ya, bro.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 2
            [
                "id_confession_comment" => 5,
                "id_confession" => 2,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Woi, seriusan sih? Ngesteal kotak pensil? Kalo lu yang ambil, kasian nih orangnya udah cari-cari. Balikin deh, jangan dibawa-bawa.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 6,
                "id_confession" => 2,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Nge-steal kotak pensil orang? Cuma pensil warna aja sih, gak sebanding sama rasa kehilangan yang dirasain pemiliknya. Kalo lo yang ambil, mending balikin aja, ya.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 7,
                "id_confession" => 2,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Parah banget sih yang beginian. Mending langsung aja lu ngaku kalo emang lu yang ambil, biar selesai. Jangan bikin orang jadi stress gini.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 8,
                "id_confession" => 2,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Gak ada kerjaan lain ya, sampe harus nge-steal kotak pensil? Kalo lo yang ambil, balikin aja, gak usah malu-malu. Kasian tuh orang udah nyari-nyari.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 3
            [
                "id_confession_comment" => 9,
                "id_confession" => 3,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Hadeh, ribet banget sih kalo gitu. Kalo kamu emang serius sama cowoknya, coba aja kamu ngobrol sama guru favorit kamu itu, bilangin kalo dia itu gebetan kamu. Siapa tau bisa dijelasin dan dia paham. Kan nggak enak juga kalo persaingan sama guru.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 10,
                "id_confession" => 3,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Hati-hati banget ya, jangan sampe gebetan km kepincut sama guru. Mungkin bisa km cari moment buat lebih deket sama dia, biar gurunya gak bisa nge-chase terus. Komunikasi sama gebetan km juga penting.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 11,
                "id_confession" => 3,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Parah banget tuh guru, nggak kenal tempat. Coba aja kmu deketin gebetan kmu lebih intens, biar gak ada ruang buat guru ikut campur. Jangan lupa buat jaga perasaan kmu sendiri juga ya.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 12,
                "id_confession" => 3,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Waduh, seriusan sih guru favorit u itu? Kalo u udah yakin sama gebetan u, mending u ekspresiin perasaan u ke dia. Siapa tau dia juga nungguin itu. Jangan biarin guru jadi penghalang antara lu sama gebetan lu.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 4
            [
                "id_confession_comment" => 13,
                "id_confession" => 4,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Kalo udah diomongin tapi tetep aja gak berubah, mungkin bisa km bicara lagi dengan lebih tegas. Jelasin dengan baik kenapa km merasa terganggu dan perlunya batasan dalam hubungan. Kalau dia sayang sama km, seharusnya bisa ngertiin.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 14,
                "id_confession" => 4,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Situasi kayak gitu bener-bener tricky, ya. Coba aja kamu bicarakan sama dia secara jujur, bilangin kalo kamu merasa gak nyaman sama sikap stalker-nya. Bisa minta dia untuk ngertiin batasan dan menghormati privasi kamu.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 5
            [
                "id_confession_comment" => 15,
                "id_confession" => 5,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Hadeh, kalo gitu, lu bisa langsung aja rekam pake handphone. Kalo dia tau lu lagi ngerekam, mungkin dia bakal berhenti. Lagian, kalo ada bukti kayak gitu, bisa lu pake buat laporan ke polisi.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 16,
                "id_confession" => 5,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Parah banget tuh cowok, gak tau diri banget. Kalo udah tegur langsung masih aja gitu, coba aja cari bantuan dari penumpang lain atau minta tolong sama sopir angkot. Mereka bisa bantu buat intervensi atau panggil polisi.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 6
            [
                "id_confession_comment" => 17,
                "id_confession" => 6,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Nggak nyantai banget sih tingkah Yudis. Gak ada salahnya lo ngasih dia balesan, tapi coba aja yang santai aja. Misalnya, lo bisa balikin leluconnya dengan candaan yang gak bikin malu, biar dia ngerti kalo lo juga bisa bales.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 18,
                "id_confession" => 6,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Coba aja kamu ngobrol langsung sama Yudis, jelasin ke dia kalo kamu gak suka dengan lelucon kayak gitu. Bisa aja dia gak sadar kalo bikin kamu malu. Kalau dia temen baik, seharusnya bisa ngertiin.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 7
            [
                "id_confession_comment" => 19,
                "id_confession" => 7,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Kalo emang udah parah dan nge-bully murid, mungkin bisa km lapor ke kepsek atau orang tua, sambil sertakan bukti-bukti kalo emang terjadi bullying. Harusnya sekolah punya kebijakan buat ngatasin masalah kayak gitu.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 20,
                "id_confession" => 7,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Kalo kmu punya kesempatan, mungkin bisa aja kmu ngobrol langsung sama guru itu, bilangin kalo kmu merasa kesulitan atau gak nyaman. Kadang-kadang, komunikasi langsung bisa bikin guru ngertiin situasi murid.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 8
            [
                "id_confession_comment" => 21,
                "id_confession" => 8,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Waduh, gurunya emang over the line banget ya. Coba aja u ngobrol langsung sama dia, jelasin kalo u gak suka dengan cara dia ngomongin privasi murid. Kadang-kadang, guru gak sadar kalo udah kelewatan.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 22,
                "id_confession" => 8,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Gak bisa gitu, harusnya guru bisa jadi contoh yang baik buat muridnya. Kalo emang udah gak nyaman, bisa banget km lapor ke kepsek atau pihak sekolah yang lebih tinggi. Privasi murid harus dihormati.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 9
            [
                "id_confession_comment" => 23,
                "id_confession" => 9,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Kalo mereka masih ngejek, mungkin bisa aja lo cari teman yang lebih menghargai hobi lo. Kadang-kadang, gak semua orang bakal bisa ngertiin atau suka dengan hobi yang agak unik. Tapi yang penting, tetep enjoy dengan apa yang lo suka.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 24,
                "id_confession" => 9,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "WokwoKOWKWKK",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            // Confession 10
            [
                "id_confession_comment" => 25,
                "id_confession" => 10,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Parah banget tuh yang bully, gak tau diri banget. Lo bisa coba cerita ke guru atau kepsek tentang kejadian ini. Mereka pasti bakal ngambil langkah buat nge-stop bullying. Kalo temen lo bisa tahu kalo ada yang peduli, mungkin dia jadi lebih kuat.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
            [
                "id_confession_comment" => 26,
                "id_confession" => 10,
                "id_user" => Arr::random($randomnessOfUsers),
                "comment" => "Nge-bully itu gak keren banget, bener deh. Kamu bisa aja curhat ke guru atau kepsek, kasih tau mereka tentang situasi temen km. Mereka pasti bisa bantu ngambil tindakan buat nge-stop bullying. Jangan biarkan temen km sendirian menghadapi ini.",
                "privacy" => Arr::random($randomnessOfPrivacy),
                "created_at" => now(),
            ],
        ]);
    }
}