<?php
$route['admin/home'] = 'admin/content';
$route['contributor/home'] = 'contributor/content';
$route['home'] = 'content';



$route['admin/article'] = 'admin/content/page/article'; $route['admin/article/add'] = 'admin/content/add_data/add'; $route['admin/article/edit/(:any)'] = 'admin/content/edit_data/edit/$1'; $route['admin/article/delete'] = 'admin/content/delete'; $route['admin/article/save'] = 'admin/content/save'; $route['admin/article/view/(:any)'] = 'admin/content/view/$1'; $route['admin/article/publishContent'] = 'admin/content/publishContent'; $route['admin/article/comments/(:any)'] = 'admin/content/comments/$1'; $route['admin/article/sendComment'] = 'admin/content/sendComment'; $route['admin/article/publishComment'] = 'admin/content/publishComment'; $route['admin/article/deleteComment'] = 'admin/content/deleteComment'; $route['contributor/article'] = 'contributor/content/page/article'; $route['contributor/article/add'] = 'contributor/content/add_data/add'; $route['contributor/article/edit/(:any)'] = 'contributor/content/edit_data/edit/$1'; $route['contributor/article/delete'] = 'contributor/content/delete'; $route['contributor/article/save'] = 'contributor/content/save'; $route['contributor/article/comments/(:any)'] = 'contributor/content/comments/$1'; $route['contributor/article/sendComment'] = 'contributor/content/sendComment'; $route['contributor/article/publishComment'] = 'contributor/content/publishComment'; $route['contributor/article/deleteComment'] = 'contributor/content/deleteComment'; $route['article'] = 'content/page/article'; $route['article/loadmore/(:any)'] = 'content/loadmore/$1'; $route['admin/article/checktitle'] = 'admin/content/checktitle'; $route['admin/article/crUpload'] = 'admin/content/crUpload'; $route['admin/article/crUpload_thumb'] = 'admin/content/crUpload_thumb'; $route['contributor/article/crUpload'] = 'contributor/content/crUpload'; $route['contributor/article/crUpload_thumb'] = 'contributor/content/crUpload_thumb';

$route['admin/gossip'] = 'admin/content/page/gossip'; $route['admin/gossip/add'] = 'admin/content/add_data/add'; $route['admin/gossip/edit/(:any)'] = 'admin/content/edit_data/edit/$1'; $route['admin/gossip/delete'] = 'admin/content/delete'; $route['admin/gossip/save'] = 'admin/content/save'; $route['admin/gossip/view/(:any)'] = 'admin/content/view/$1'; $route['admin/gossip/publishContent'] = 'admin/content/publishContent'; $route['admin/gossip/comments/(:any)'] = 'admin/content/comments/$1'; $route['admin/gossip/sendComment'] = 'admin/content/sendComment'; $route['admin/gossip/publishComment'] = 'admin/content/publishComment'; $route['admin/gossip/deleteComment'] = 'admin/content/deleteComment'; $route['contributor/gossip'] = 'contributor/content/page/gossip'; $route['contributor/gossip/add'] = 'contributor/content/add_data/add'; $route['contributor/gossip/edit/(:any)'] = 'contributor/content/edit_data/edit/$1'; $route['contributor/gossip/delete'] = 'contributor/content/delete'; $route['contributor/gossip/save'] = 'contributor/content/save'; $route['contributor/gossip/comments/(:any)'] = 'contributor/content/comments/$1'; $route['contributor/gossip/sendComment'] = 'contributor/content/sendComment'; $route['contributor/gossip/publishComment'] = 'contributor/content/publishComment'; $route['contributor/gossip/deleteComment'] = 'contributor/content/deleteComment'; $route['gossip'] = 'content/page/gossip'; $route['gossip/loadmore/(:any)'] = 'content/loadmore/$1'; $route['admin/gossip/checktitle'] = 'admin/content/checktitle'; $route['admin/gossip/crUpload'] = 'admin/content/crUpload'; $route['admin/gossip/crUpload_thumb'] = 'admin/content/crUpload_thumb'; $route['contributor/gossip/crUpload'] = 'contributor/content/crUpload'; $route['contributor/gossip/crUpload_thumb'] = 'contributor/content/crUpload_thumb';

$route['admin/profile'] = 'admin/content/page/profile'; $route['admin/profile/add'] = 'admin/content/add_data/add'; $route['admin/profile/edit/(:any)'] = 'admin/content/edit_data/edit/$1'; $route['admin/profile/delete'] = 'admin/content/delete'; $route['admin/profile/save'] = 'admin/content/save'; $route['admin/profile/view/(:any)'] = 'admin/content/view/$1'; $route['admin/profile/publishContent'] = 'admin/content/publishContent'; $route['admin/profile/comments/(:any)'] = 'admin/content/comments/$1'; $route['admin/profile/sendComment'] = 'admin/content/sendComment'; $route['admin/profile/publishComment'] = 'admin/content/publishComment'; $route['admin/profile/deleteComment'] = 'admin/content/deleteComment'; $route['contributor/profile'] = 'contributor/content/page/profile'; $route['contributor/profile/add'] = 'contributor/content/add_data/add'; $route['contributor/profile/edit/(:any)'] = 'contributor/content/edit_data/edit/$1'; $route['contributor/profile/delete'] = 'contributor/content/delete'; $route['contributor/profile/save'] = 'contributor/content/save'; $route['contributor/profile/comments/(:any)'] = 'contributor/content/comments/$1'; $route['contributor/profile/sendComment'] = 'contributor/content/sendComment'; $route['contributor/profile/publishComment'] = 'contributor/content/publishComment'; $route['contributor/profile/deleteComment'] = 'contributor/content/deleteComment'; $route['profile'] = 'content/page/profile'; $route['profile/loadmore/(:any)'] = 'content/loadmore/$1'; $route['admin/profile/checktitle'] = 'admin/content/checktitle'; $route['admin/profile/crUpload'] = 'admin/content/crUpload'; $route['admin/profile/crUpload_thumb'] = 'admin/content/crUpload_thumb'; $route['contributor/profile/crUpload'] = 'contributor/content/crUpload'; $route['contributor/profile/crUpload_thumb'] = 'contributor/content/crUpload_thumb';

/* review */
$route['admin/news'] = 'admin/content/page/news'; $route['admin/news/add'] = 'admin/content/add_data/add'; $route['admin/news/edit/(:any)'] = 'admin/content/edit_data/edit/$1'; $route['admin/news/delete'] = 'admin/content/delete'; $route['admin/news/save'] = 'admin/content/save'; $route['admin/news/view/(:any)'] = 'admin/content/view/$1'; $route['admin/news/publishContent'] = 'admin/content/publishContent'; $route['admin/news/comments/(:any)'] = 'admin/content/comments/$1'; $route['admin/news/sendComment'] = 'admin/content/sendComment'; $route['admin/news/publishComment'] = 'admin/content/publishComment'; $route['admin/news/deleteComment'] = 'admin/content/deleteComment'; $route['contributor/news'] = 'contributor/content/page/news'; $route['contributor/news/add'] = 'contributor/content/add_data/add'; $route['contributor/news/edit/(:any)'] = 'contributor/content/edit_data/edit/$1'; $route['contributor/news/delete'] = 'contributor/content/delete'; $route['contributor/news/save'] = 'contributor/content/save'; $route['contributor/news/comments/(:any)'] = 'contributor/content/comments/$1'; $route['contributor/news/sendComment'] = 'contributor/content/sendComment'; $route['contributor/news/publishComment'] = 'contributor/content/publishComment'; $route['contributor/news/deleteComment'] = 'contributor/content/deleteComment'; $route['news'] = 'content/page/news'; $route['news/loadmore/(:any)'] = 'content/loadmore/$1'; $route['admin/news/checktitle'] = 'admin/content/checktitle'; $route['admin/news/crUpload'] = 'admin/content/crUpload'; $route['admin/news/crUpload_thumb'] = 'admin/content/crUpload_thumb'; $route['contributor/news/crUpload'] = 'contributor/content/crUpload'; $route['contributor/news/crUpload_thumb'] = 'contributor/content/crUpload_thumb';
/* end of review */

/* page of contents */
$route['aktris-park-shin-hye-bikin-heboh-dimalaysia'] = 'readmore/read/1476629258admin';
$route['drama-korea-terbaru-aktor-tampan-lee-min-ho'] = 'readmore/read/1476636772admin';
$route['park-bo-geum'] = 'readmore/read/1476871149admin';
$route['jin-young'] = 'readmore/read/1476871351admin';
$route['jung-il-woo'] = 'readmore/read/1476871453admin';
$route['ahn-jae-hyun'] = 'readmore/read/1476872073admin';
$route['lee-jung-shin'] = 'readmore/read/1476872177admin';
$route['im-yoon-ah'] = 'readmore/read/1476872297admin';
$route['ji-chang-wook'] = 'readmore/read/1476872419admin';
$route['lee-joon-ki'] = 'readmore/read/1476872604admin';
$route['profile-iu'] = 'readmore/read/1476872690admin';
$route['lee-jong-suk'] = 'readmore/read/1476872786admin';
$route['han-hyo-joo'] = 'readmore/read/1476872880admin';
$route['list-drama-korea-di-bulan-oktober-2016'] = 'readmore/read/1476933111admin';
$route['benarkah-beast-telah-meninggalkan-cube-entertainment-'] = 'readmore/read/1476950385admin';
$route['wah-exo-bikin-public-ngiler'] = 'readmore/read/1477046423admin';
$route['profil-lengkap-personil-bangtan-boys'] = 'readmore/read/1477380075admin';
$route['heboh-big-bang-pake-kous-salah-satu-partai-indonesia'] = 'readmore/read/1477302880admin';
$route['sechs-kies---three-words'] = 'readmore/watch/1476629292admin';
$route['breath'] = 'readmore/watch/1476959180admin';
$route['galaxy'] = 'readmore/watch/1476960074admin';
$route['blood-sweat-and-tears'] = 'readmore/watch/1477362101admin';
$route['fall'] = 'readmore/watch/1477300305admin';
$route['50-x-half'] = 'readmore/watch/1477301902admin';
$route['im'] = 'readmore/watch/1477302294admin';
$route['1-of-1'] = 'readmore/watch/1477363139admin';
$route['mengukir-prestasi-g-dragon-mendapatkan-penghargaan-dari-perdana-menteri-korea-selatan'] = 'readmore/read/1477463807admin';
$route['benarkah-gary-tinggalkan-running-man'] = 'readmore/read/1477541051admin';
$route['black-pink-comeback-dengan-perilisan-square-two'] = 'readmore/read/1477886458admin';
$route['exo-dan-bts-dikonfirmasi-akan-hadir-di-mama-2016'] = 'readmore/read/1477982295admin';
$route['btob-tampil-maskulin-di-teaser-terbaru-untuk-new-man'] = 'readmore/read/1477968281admin';
$route['black-pink-comeback-dengan-perilisan-square-two'] = 'readmore/read/1477886458admin';
$route['exo-dan-bts-dikonfirmasi-akan-hadir-di-mama-2016'] = 'readmore/read/1477982295admin';
$route['pihak-lee-min-ho-laporkan-penyebar-gosip-buruk-ke-kantor-polisi-gangnam'] = 'readmore/read/1477984765admin';
$route['yonghwa-sempat-dirumorkan-lakukan-hal-ilegal-fnc-ambil-langkah-hukum-tanggapi-berita-palsu'] = 'readmore/read/1477986534admin';
$route['wah-netizen-khawatir-yoona-snsd-akan-terseret-dalam-skandal-presiden'] = 'readmore/read/1477988902admin';
$route['legend-of-the-blue-sea-merilis-poster-individu-lee-min-ho-dan-jun-ji-hyun'] = 'readmore/read/1477971034admin';
$route['wah-gantengnya-lee-min-ho-jadi-pegawai-kantoran-di-potongan-gambar-legend-of-the-blue-sea'] = 'readmore/read/1477971392admin';
$route['lay-exo-konfirmasi-comeback-drama-bersama-aktris-cina-operation-love'] = 'readmore/read/1477985064admin';
$route['sinopsis-drama-korea-the-k2'] = 'readmore/read/1477988077admin';
$route['sinopsis-drama-korea--w--two-worlds'] = 'readmore/read/1478145428admin';
$route['sinopsis-drama-korea-something-about-1'] = 'readmore/read/1478146384admin';
$route['sinopsis-moon-lovers-scarlet-heart-ryeo'] = 'readmore/read/1478161827nesia';
$route['ditinggal-gary-running-man-undang-sechs-kies-jadi-bintang-tamu'] = 'readmore/read/1478585928nesia';
$route['kyuhyun-rilis-teaser-comeback-dengan-lagu-still'] = 'readmore/read/1478592030nesia';
$route['lee-hongki-ft-island-resmi-pacaran-dengan-han-bo-reum'] = 'readmore/read/1478680411nesia';
$route['park-bo-gum-siap-sapa-penggemar-di-jakarta-awal-tahun-depan'] = 'readmore/read/1478685171nesia';
$route['ini-daftar-harga-tiket-dan-seatplan-untuk-jumpa-fans-park-bo-gum-di-jakarta'] = 'readmore/read/1478764639nesia';

$route['penuh-tawa-serunya-lee-min-ho---jun-ji-hyun-syuting-legend-of-the-blue-sea'] = 'readmore/read/1478765553nesia';
$route['keren--tt-dan-russian-roulette-masuk-rekomendasi-brilliant-songs-situs-buzzfeed'] = 'readmore/read/1479112847nesia';
$route['3-grup-idol-ini-menjadi-panutan-dari-cha-eun-woo-astro'] = 'readmore/read/1479270093nesia';
$route['foto-bareng-siwon-donghae-dan-changmin-brian-joo-serasa-reunian-artis-sm'] = 'readmore/read/1479356824nesia';

$route['rating-debut-legend-blue-sea-kalahkan-descendants-dan-my-love-from-the-star'] = 'readmore/read/1479364070nesia';
$route['borong-5-trofi-di-aaa-2016-baekhyun-exo-pamer-sambil-ucapkan-terima-kasih'] = 'readmore/read/1479365933nesia';
$route['yoon-mi-rae-sumbangkan-suaranya-untuk-drama-the-legend-of-the-blue-sea'] = 'readmore/read/1480048369nesia';
$route['disangka-mencoba-bunuh-diri-sulli-jelaskan-sayatan-pada-tangannya'] = 'readmore/read/1480065624nesia';
$route['ini-dia-sinopsis-lengkap-drama-first-kiss-for-the-seventh-time-yang-dibintangi-7-aktor-ganteng-sekaligus'] = 'readmore/read/1480070137nesia';
$route['kim-min-jae-dan-kim-so-hyun-muncul-sebagai-raja-dan-ratu-di-drama-goblin'] = 'readmore/read/1480317793nesia';
$route['biodata-song-joong-ki-lengkap'] = 'readmore/read/1480320903nesia';
$route['tinggalkan-cube-entertainment-beast-dirikan-agensi-good-luck'] = 'readmore/read/1480495100nesia';
$route['sinopsis-drama-korea-goblin-2016'] = 'readmore/read/1480913181nesia';
$route['lee-cho-hee-kaget-bertemu-lee-jun-ki-di-episode-pertama-7-first-kisses'] = 'readmore/read/1480921445nesia';
$route['first-kiss-for-the-seventh-time-rilis-video-teaser-pertama'] = 'readmore/read/1480922919nesia';

$route['kangen-i-hear-your-voice-lee-jong-suk-pamer-peluk-lee-bo-young-cs'] = 'readmore/read/1480929504nesia';

$route['jonghyun-shinee-isi-sm-station-minggu-ini-dengan-lagu-ciptaannya'] = 'readmore/read/1480933447nesia';
$route['exo-dan-suga-bts-masuk-dalam-daftar-20-album-terpopuler-di-tumblr-tahun-2016'] = 'readmore/read/1481257103nesia';
$route['bts-bicara-tentang-konsep-seksi-hingga-menjadi-idol-populer-super-sibuk'] = 'readmore/read/1481871540nesia';
$route['20-lagu-k-pop-terbaik-sepanjang-2016-versi-majalah-inggris-dazed'] = 'readmore/read/1481872645nesia';
$route['stay-with-me'] = 'readmore/watch/1482312274nesia';
$route['pakai-setelan-gelap-lee-dong-wook-super-ganteng-di-bts-goblin'] = 'readmore/read/1482315679nesia';