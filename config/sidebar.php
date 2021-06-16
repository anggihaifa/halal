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
            'url' => 'listregistrasipelangganaktif',
          
        ],
        [   'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],
        [   'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
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
                ],    
                [
                    
                    'url' => 'dokumen.index',
                    'title' => 'Reporsitory Dokumen Halal'
                ],   
                [    
                   
                    'url' => 'guideline.index',
                    'title' => 'Guideline'
                ],    
                [
                    'url' => 'user.index',
                    'title' => 'Pengguna'
                ],
                [
                    'url' => 'usergroup.index',
                    'title' => 'Grup Pengguna'
                ],     
                [
                    'url' => 'detailpelaksana.index',
                    'title' => 'Data Pelaksana'
                ],        
            ],
        ],        
    ],
    'menu2' => [ //user
        [
            'icon' => 'ion-ios-home',
            'title' => 'Home',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => 'registrasiHalal.index',
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Unduh Form',
            'url' => 'dokumen.indexpelanggan'
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
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
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
            'url' => 'listregistrasipelangganaktif',
            
        ],
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
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
                ],    
                [
                    
                    'url' => 'dokumen.index',
                    'title' => 'Reporsitory Dokumen Halal'
                ],   
                [    
                   
                    'url' => 'guideline.index',
                    'title' => 'Guideline'
                ],    
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
    'preregistrasi' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Registrasi',
            'url' => 'registrasiHalal.index',
            /*'caret' => true,
            'sub_menu' => [
                [
                    'url' => 'registrasiHalal.index',
                    'title' => 'Registrasi Halal'
                ]
            ],*/
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Unduh Form',
            'url' => 'dokumen.indexpelanggan'
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
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],
    ],
   
    'menu4fix' => [
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
                    'url' => 'listpembayaranregistrasi',
                    'title' => 'Penawaran Harga dan Kontrak Akad'
                ],
                // [
                //     'url' => 'listakadadmin',
                //     'title' => 'List Kontrak Akad'
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
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
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
            'title' => 'Menu Keuangan',
            'url' => 'listkeuangan',
            
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],        
    ],
   
    'menu6fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Monitoring Registrasi',
            'url' => 'listmonitoringregistrasi',          
        ],  
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penentuan Kebutuhan Waktu Audit',
            'url' => 'reviewkebutuhanwaktuaudit'
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penjadwalan',
            'url' => 'listpenjadwalanreviewer'
        ],
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Master',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
               
                [
                    
                    'url' => 'dokumen.index',
                    'title' => 'Reporsitory Dokumen Halal'
                ],   
                [    
                   
                    'url' => 'guideline.index',
                    'title' => 'Guideline'
                ],    
                
                [
                    'url' => 'detailpelaksana.index',
                    'title' => 'Data Auditor'
                ],        
            ],
        ],        
        
      
    ],        
 
    'menu7fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        
        [    'icon' => 'ion-md-information-circle-outline',
            'title' => 'Berita',
            'url' => 'berita.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],         
                                      
    ],
  
    'menu8fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],  
                                      
    ],
    'menu9fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
       
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],  
                                      
    ],
  
    'menu10fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Jadwal Audit',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                         
                [
                    'url' => 'listaudit1',
                    'title' => 'Audit Tahap 1'
                ],
                [
                    'url' => 'listaudit2',
                    'title' => 'Audit Tahap 2'
                ],
            ],

        ], 
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Log',
            'url' => 'listlog'
        ], 
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],
    ],
    'menu11fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Penentuan Kebutuhan Waktu Audit',
            'url' => 'listkebutuhanwaktuaudit'
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Jadwal Audit',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                         
                [
                    'url' => 'listaudit1',
                    'title' => 'Audit Tahap 1'
                ],
                [
                    'url' => 'listaudit2',
                    'title' => 'Audit Tahap 2'
                ],  
                [
                    'url' => 'listtehnicalreview',
                    'title' => 'List Tehnical Review'
                ],  
            ],

        ],
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Log',
            'url' => 'listlog'
        ], 
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],        
    ],
    'menu12fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Jadwal Audit',
            'url' => '#',
            'caret' => true,
            'sub_menu' => [
                         
                [
                    'url' => 'listaudit1',
                    'title' => 'Audit Tahap 1'
                ],
                [
                    'url' => 'listaudit2',
                    'title' => 'Audit Tahap 2'
                ],
                [
                    'url' => 'listtehnicalreview',
                    'title' => 'List Tehnical Review'
                ],  
            ],

        ],
       
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Log',
            'url' => 'listlog'
        ], 
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],       
    ],
    'menu13fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],        
        [
            'icon' => 'ion-ios-calendar',
            'title' => 'Tinjauan Komite Sertifikasi',
            'url' => 'listtinjauan'
        ],
        [
            'icon' => 'ion-ios-cube',
            'title' => 'Log',
            'url' => 'listlog'
        ], 
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],
    ],
    'menu14fix' => [
        [
            'icon' => 'ion-ios-stats',
            'title' => 'Dashboard',
            'url' => 'home.index'
        ],        
        [    'icon' => 'ion-ios-clipboard',
            'title' => 'Pelatihan',
            'url' => 'pelatihan.index'
        ],
        [
            'icon' => 'ion-md-book',
            'title' => 'Reporsitory Dokumen Halal',
            'url' => 'dokumen.indexuser'
        ],
    ],
];

