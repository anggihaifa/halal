<?php

$angka  = 9;

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
    'menu' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-ios-people',
            'title' => 'Pelanggan',
            'url' => 'user.listpelanggan'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                /*[
                    'url' => 'listregistrasipelanggan',
                    'title' => 'List Registrasi Halal '
                ],*/
                 [
                    'url' => 'listregistrasipelangganaktif',
                    'title' => 'List Registrasi Aktif'
                ],
                [
                    'url' => 'listakadadmin',
                    'title' => 'List Kontrak Akad'
                ],
                [
                    'url' => 'listpembayaranregistrasi',
                    'title' => 'List Pembayaran Tahap1'
                ],
                [
                    'url' => 'listpembayarantahap2',
                    'title' => 'List Pembayaran Tahap 2'
                ],
                
                [
                    'url' => 'listpelunasan',
                    'title' => 'List Pelunasan'
                ],
                 

               
            ],
        ],
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Master',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'jenis_registrasi.index',
                    'title' => 'Jenis Registrasi'
                ],
                [
                    'url' => 'kelompok_produk.index',
                    'title' => 'Kelompok Produk'
                ],
                [
                    'url' => 'faq.index',
                    'title' => 'F.A.Q'
                ]
            ],
        ],
        [
            'icon' => 'fa fa-cog',
            'title' => 'Pengaturan',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'user.index',
                    'title' => 'Pengguna'
                ],
                [
                    'url' => 'usergroup.index',
                    'title' => 'Grup Pengguna'
                ],
            ],
        ],
    ],
    'menu2' => [
        [
            'icon' => 'ion-ios-home',
            'title' => 'Home',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'registrasiHalal.index',
                    'title' => 'Registrasi Halal'
                ],
                [
                    'url' => 'registrasi.unggahDataSertifikasi',
                    'title' => 'Unggah Data Sertifikasi'
                ],
                /*[
                    'url' => 'registrasi.pembayaranRegistrasi',
                    'title' => 'Pembayaran Sertifikasi Halal'
                ],*/
                    
            ],
        ],
        [
            'icon' => 'ion-ios-home',
            'title' => 'F.A.Q',
            'url' => 'faq.index'
        ],
    ],
    'menu3' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-ios-people',
            'title' => 'Pelanggan',
            'url' => 'user.listpelanggan'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
               /* [
                    'url' => 'listregistrasipelanggan',
                    'title' => 'List Registrasi Halal'
                ],*/
                 [
                    'url' => 'listregistrasipelangganaktif',
                    'title' => 'List Registrasi Aktif'
                ],
                [
                    'url' => 'listakadadmin',
                    'title' => 'List Kontrak Akad'
                ],
                [
                    'url' => 'listpembayaranregistrasi',
                    'title' => 'List Pembayaran Tahap1'
                ],
                [
                    'url' => 'listpembayarantahap2',
                    'title' => 'List Pembayaran Tahap 2'
                ],
                
                [
                    'url' => 'listpelunasan',
                    'title' => 'List Pelunasan'
                ],
                // [
                //     'url' => 'listunggahdatasertifikasi',
                //     'title' => 'Unggah Data Sertifikasi',
                // ],
            ],
        ],
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Master',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'jenis_registrasi.index',
                    'title' => 'Jenis Registrasi'
                ],
                [
                    'url' => 'kelompok_produk.index',
                    'title' => 'Kelompok Produk'
                ],
                [
                    'url' => 'faq.index',
                    'title' => 'F.A.Q'
                ]
            ],
        ],
    ],
    'preregistrasi' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'registrasiHalal.index',
                    'title' => 'Registrasi Halal'
                ]
            ],
        ],
    ],
    'menu4' => [
         [
            'icon' => 'ion-ios-home',
            'title' => 'Home',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'registrasiHalal.index',
                    'title' => 'Registrasi Halal'
                ],
                [
                    'url' => 'registrasi.unggahDataSertifikasi',
                    'title' => 'Unggah Data Sertifikasi'
                ],
                /*[
                    'url' => 'pembayaran_registrasi/107',
                    'title' => 'Pembayaran Sertifikasi Halal'
                ],*/
            ],
        ],
        [
            'icon' => 'ion-ios-home',
            'title' => 'F.A.Q',
            'url' => 'faq.index'
        ],
    ],
];

