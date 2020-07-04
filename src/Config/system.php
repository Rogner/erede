<?php
return [
    [
        'key' => 'sales.paymentmethods.erede',
        'name' => 'Erede',
        'sort' => 100,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'Título',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name' => 'description',
                'title' => 'Descrição',
                'type' => 'textarea',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name' => 'pv',
                'title' => 'PV de Integração',
                'type' => 'text',
                'validation' => 'required',
                'info' => 'PV gerado na sua conta E-Rede.'
            ],[
                'name' => 'token',
                'title' => 'Token de Integração',
                'type' => 'text',
                'validation' => 'required',
                'info' => 'Token gerado na sua conta E-Rede.'
            ], [
                'name' => 'sandbox',
                'title' => 'Sandbox',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true,
            ],
            [
                'name' => 'debug',
                'title' => 'Debug log?',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Ativo',
                        'value' => true
                    ], [
                        'title' => 'Inativo',
                        'value' => false
                    ]
                ],
                'validation' => 'required'
            ], [
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Ativo',
                        'value' => true
                    ], [
                        'title' => 'Inativo',
                        'value' => false
                    ]
                ],
                'validation' => 'required'
            ]
        ]
    ]
];