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
                    'title' => 'List Pembayaran Tahap 1'
                ],
                [
                    'url' => 'listpembayarantahap2',
                    'title' => 'List Pembayaran Tahap 2'
                ],

     
                [   
                    'url' => 'listberitaacara',       
                    'title' => 'Pelaporan Audit dan Berita Acara'                    
                ],
                 [
                    'url' => 'listpelunasan',
                    'title' => 'List Pelunasan'
                ],
               
            ],
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penjadwalan',
            'url' => 'listpenjadwalanadmin'
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
                ],
                 [
                    'url' => 'akomodasi.index',
                    'title' => 'Akomodasi'
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
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.index'
        ],
        [    'icon' => 'ion-ios-person',
            'title' => 'Guideline',
            'url' => 'guideline.index'
        ],
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
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
                
            ],
        ],
        [
            'icon' => 'ion-ios-home',
            'title' => 'F.A.Q',
            'url' => 'faq.index'
        ],
        [    'icon' => 'ion-ios-person',
            'title' => 'Guideline',
            'url' => 'guideline.index'
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
                    'title' => 'List Pembayaran Tahap 1'
                ],
                [
                    'url' => 'listpembayarantahap2',
                    'title' => 'List Pembayaran Tahap 2'
                ], 
                [   
                    'url' => 'listberitaacara',       
                    'title' => 'Pelaporan Audit dan Berita Acara'                    
                ],
                 [
                    'url' => 'listpelunasan',
                    'title' => 'List Pelunasan'
                ],
               
            ],
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penjadwalan',
            'url' => 'listpenjadwalanadmin'
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
                ],
                [
                    'url' => 'akomodasi.index',
                    'title' => 'Akomodasi'
                ]  
            ],
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ], 
        [    'icon' => 'ion-ios-person',
            'title' => 'Guideline',
            'url' => 'guideline.index'
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
         [
            'icon' => 'ion-ios-help-circle',
            'title' => 'F.A.Q',
            'url' => 'faq.index'
        ],
        [
            'icon' => 'ion-ios-person',
            'title' => 'Guideline',
            'url' => 'guideline.index'
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
            'icon' => 'ion-ios-help-circle',
            'title' => 'F.A.Q',
            'url' => 'faq.index'
        ],
        [
            'icon' => 'ion-ios-person',
            'title' => 'Guideline',
            'url' => 'guideline.index'
        ],
    ],
    'menu5' => [
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
                /*[
                    'url' => 'listregistrasipelanggan',
                    'title' => 'List Registrasi Halal '
                ],*/                 
                [
                    'url' => 'listakadreviewer',
                    'title' => 'List Kontrak Akad'
                ],                
               
                //  [
                //     'url' => 'listpelunasanreviewer',
                //     'title' => 'List Pelunasan'
                // ],
               
            ],
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ], 
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
        ],
    ],
    'menu6' => [
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
                /*[
                    'url' => 'listregistrasipelanggan',
                    'title' => 'List Registrasi Halal '
                ],*/                 
                [
                    'url' => 'listakadapprover',
                    'title' => 'List Kontrak Akad'
                ]   
            ],
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],  
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],                             
    ],
    'menu10' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],    
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.index'
        ],        
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],                             
    ],
    'menu7' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],        
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penjadwalan',
            'url' => 'listpenjadwalanauditor'
        ],                                     
    ],
];

