<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => env('APP_NAME','Entrevistas'),

    'title_prefix' => env('APP_NAME_PRE',''),

    'title_postfix' => env('APP_NAME_POST',''),

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Comisión</b> Verdad',

    'logo_mini' => '<b>C</b>V',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |>
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => env('COLOR','purple'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    //'register_url' => 'register',
    'register_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'Reportes',
        [
            'text'        => 'Estadísticas',
            'icon'        => 'pie-chart',
            'submenu' => [
                [
                    'text'        => 'Metadatos: entrevistas',
                    'url'         => 'dash',
                    'icon'        => 'bar-chart',
                ],
                [
                    'text'        => 'Datos: ficha víctima',
                    'url'         => 'pre/dash/fichas_vi',
                    'icon'        => 'area-chart',
                ],
                [
                    'text'        => 'Mapa',
                    'url'         => 'mapa/e_ind_fvt',
                    'icon'        => 'map',
                ],
                /*
                [
                    'text'        => 'Uso de etiquetas',
                    'url'         => 'tesauro/circulos',
                    'icon'        => 'tree',
                ],
                */
                ]

        ],

        [
            'text' => 'Descargar datos en excel',
            'url'  => 'excel/descarga',
            'icon' => 'file-excel-o',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Buscadora',
            'url'  => 'buscador',
            'icon' => 'smile-o',
            //'can'  => 'nivel-1-al-6',
            'icon_color' => 'purple',
        ],
        [
            'text' => 'Personas entrevistadas',
            'url'  => 'reporte/entrevistados',
            'icon' => 'users',
            'can'  => 'rol-reporte-entrevistados',
        ],
        [
            'text' => 'Árbol de etiquetas',
            'url'  => 'tesauro/completo',
            'icon' => 'tree',
            'icon_color' => 'green',
        ],
        [
            'text' => 'Casos transversales',
            'url'  => 'misCasos',
            'icon' => 'briefcase',
            //'can'  => 'mis-casos',

            'icon_color' => 'aqua',

        ],
        'Esclarecimiento',
        [
            'text' => 'Víctimas, familiares o testigos',
            'url'  => 'entrevistaIndividuals?id_subserie='.env('E_VI'),
            'icon_color' => 'aqua',
            'icon'        => 'flag',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Actores armados',
            'url'  => 'entrevistaIndividuals?id_subserie='.env('E_AA'),
            'icon_color' => 'aqua',
            'icon'        => 'user-secret',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Terceros civiles',
            'url'  => 'entrevistaIndividuals?id_subserie='.env('E_TC'),
            'icon_color' => 'aqua',
            'icon'        => 'user-circle',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Entrevista colectiva',
            'url'  => 'entrevistaColectivas',
            'icon_color' => 'aqua',
            //'label'       => "nuevo",
            'icon'        => 'wechat',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Entrevista sujeto colectivo',
            'url'  => 'entrevistaEtnicas',
            'icon_color' => 'aqua',
            //'label'       => "nuevo",
            'icon'        => 'comments-o',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Entrev. profundidad',
            'url'  => 'entrevistaProfundidads',
            'icon_color' => 'aqua',
            //'label'       => "nuevo",
            'icon'        => 'handshake-o',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Diagnóstico comunitario',
            'url'  => 'diagnosticoComunitarios',
            'icon_color' => 'aqua',
            'icon'        => 'users',
            'can'  => 'nivel-1-al-6-trans',
        ],
        [
            'text' => 'Historia de vida',
            'url'  => 'historiaVidas',
            'icon'        => 'street-view',
            'icon_color' => 'aqua',
            'can'  => 'nivel-1-al-6-trans',

        ],
        [
            'text'        => 'Casos e informes',
            'url'         => 'casosInformes',
            'icon'        => 'book',
            'icon_color' => 'aqua',
            //'label'       => 4,
            'label_color' => 'success',
            'can'  => 'nivel-1-al-6',

        ],



        [
            'text'    => 'Niños, niñas y adolescentes',
            'icon'    => 'child',
            'can'  => 'nivel-1-al-6',
            'submenu' => [
                [
                    'text' => 'Evaluación de vulnerabilidad',
                    'url'  => 'nnaVulnerabiliads',
                    'icon'    => 'question-circle',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Evaluación de seguridad',
                    'url'  => 'nnaSeguridads',
                    'icon'    => 'exclamation-circle',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Documentos de referencia',
                    'url'  => 'documentos?descripcion=niñ',
                    'icon'    => 'file-pdf-o',
                    'icon_color' => 'aqua',
                ],

            ]
        ],
        [
            'text'        => 'Archivos en el exilio',
            'url'         => 'censoArchivos',
            'icon'        => 'globe',
            'icon_color' => 'aqua',
            //'label'       => 4,
            'label_color' => 'success',
            //'can'  => 'rol-censo',
            //'label'       => "nuevo",

        ],





        'Procesamiento',
        [
            'text' => 'Asignar entrevistas (prioridad)',
            'url'  => 'procesamiento/prioridad',
            'icon' => 'sitemap',
            'can'  => 'procesamiento',
        ],
        [
            'text' => 'Asignaciones para transcribir',
            'url'  => 'transcribirAsignacions',
            'icon' => 'headphones',
            'can'  => 'procesamiento',
        ],

        [
            'text' => 'Asignaciones para etiquetar',
            'url'  => 'etiquetarAsignacions',
            'icon' => 'tags',
            'can'  => 'procesamiento',
        ],
        [
            'text' => 'Transcripciones - resumen',
            'url'  => 'transcripciones/cuadro_resumen',
            'icon' => 'table',
            'can'  => 'procesamiento',
        ],
        [
            'text' => 'Etiquetado - resumen',
            'url'  => 'etiquetado/cuadro_resumen',
            'icon' => 'table',
            'can'  => 'procesamiento',
        ],
        [
            'text' => 'Seguimiento a entrevistas',
            'url'  => 'seguimiento',
            'icon' => 'thumb-tack',

        ],





        'Gestión',
        [
            'text'    => 'Catálogos',
            'icon'    => 'list-ul',
            'can'  => 'rol-tesauro',
            'submenu' => [
                [
                    'text' => 'Personalizar listados',
                    'url'  => 'catalogos',
                    'icon' => 'list',
                    'can'  => 'rol-tesauro',
                ],
                [
                    'text' => 'Revisar "otros, ¿cuál?"',
                    'url'  => 'revisar_catalogo',
                    'icon' => 'check-square-o',
                    'can'  => 'rol-tesauro',
                ],
                [
                'text' => 'Homologar respuestas',
                'url'  => 'homologador',
                'icon' => 'check-circle-o',
                'can'  => 'rol-tesauro',
                ],
                [
                    'text' => 'Recategorizar opciones',
                    'url'  => 'reclasificacion',
                    'icon' => 'edit',
                    'can'  => 'rol-tesauro',
                ]
            ]
        ],
        [
            'text' => 'Entrevistadores/as',
            'url'  => 'entrevistadors',
            'icon' => 'users',
            'can'  => 'nivel-1',
        ],
        [
            'text' => 'Revisar entrevistas',
            'url'  => 'pys',
            'icon' => 'star-o',
            //'label'       => "nuevo",
            'can'  => 'sistema-abierto',
        ],
        [
            'text' => 'Accesos otorgados',
            'url'  => 'accesoEdicions',
            'icon' => 'share-alt',
        ],
        [
            'text' => 'Desclasificación ',
            'url'  => 'desclasificars',
            'icon' => 'eye-slash',
            'can'  => 'nivel-1',
            'icon_color' => 'red',
        ],



        [
            'text'    => 'Forzar generar exceles',
            'icon'    => 'file-excel-o',
            'can'  => 'nivel-1',
            'submenu' => [
                [
                    'text' => 'Entrevistas individuales',
                    'url'  => 'excel_generar/entrevistas_fvt',
                    //'icon'    => 'question-circle',
                    //'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Dinámicas',
                    'url'  => 'excel_generar/dinamicas_fvt',
                ],
                [
                    'text' => 'Entrevistas a profundidad',
                    'url'  => 'excel_generar/entrevistas_pr',
                ],
                [
                    'text' => 'Entrevistas a sujeto colectivo',
                    'url'  => 'excel_generar/entrevistas_ee',
                ],
                [
                    'text' => 'Integrado de entrevistas',
                    'url'  => 'excel_generar/entrevistas_integrado',
                    //'icon'    => 'question-circle',
                    //'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Integrado para SIM',
                    'url'  => 'sim_generar/victimas',
                    //'icon'    => 'question-circle',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Fichas de P. entrevistadas',
                    'url'  => 'excel_generar/fichas_persona_entrevistada',
                ],
                [
                    'text' => 'Fichas de víctimas',
                    'url'  => 'excel_generar/fichas_victima',
                ],
                [
                    'text' => 'Fichas de exilio',
                    'url'  => 'excel_generar/exilio',
                ],
                [
                    'text' => 'Traza de actividad',
                    'url'  => 'excel_generar/traza',
                ],
                [
                    'text' => 'Casos e infomes',
                    'url'  => 'excel_generar/casos',
                ],
                [
                    'text' => 'Seguimiento a entrevistas',
                    'url'  => 'excel_generar/seguimiento',
                ],
                [
                    'text' => 'Exilio: primera salida',
                    'url'  => 'analitica_generar/exilio_salida',
                ],
                [
                    'text' => 'Clasificador nvivo',
                    'url'  => 'excel_generar/nvivo',
                ],
                [
                    'text' => 'Calificacion de adjuntos',
                    'url'  => 'excel_generar/control_calificacion',
                ],
            ]
        ],




        [
            'text' => 'Traza de actividad',
            'url'  => 'trazaActividads',
            'icon' => 'user-secret ',
            //'can'  => 'nivel-1',
        ],
        [
            'text' => 'Traslados',
            'url'  => 'enlaces',
            'icon' => 'link',
            'can'  => 'nivel-1',
        ],
        [
            'text' => 'Mi perfil',
            'url'  => '/ver_perfil',
            'icon' => 'user',
        ],

        [
            'text' => 'Ayuda',
            'url'  => '/faq',
            'icon' => 'question',
            'icon_color' => 'green',
            'can'  => 'sistema-abierto',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
