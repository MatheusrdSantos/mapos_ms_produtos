<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'produtos' => [
        [
            'field' => 'descricao',
            'label' => '',
            'rules' => 'required|trim',
        ],
        [
            'field' => 'unidade',
            'label' => 'Unidade',
            'rules' => 'required|trim',
        ],
        [
            'field' => 'precoCompra',
            'label' => 'Preço de Compra',
            'rules' => 'required|trim',
        ],
        [
            'field' => 'precoVenda',
            'label' => 'Preço de Venda',
            'rules' => 'required|trim',
        ],
        [
            'field' => 'estoque',
            'label' => 'Estoque',
            'rules' => 'required|trim',
        ],
        [
            'field' => 'estoqueMinimo',
            'label' => 'Estoque Minimo',
            'rules' => 'trim',
        ]
    ],
    'produtosUpdate' => [
        [
            'field' => 'descricao',
            'label' => '',
            'rules' => 'trim',
        ],
        [
            'field' => 'unidade',
            'label' => 'Unidade',
            'rules' => 'trim',
        ],
        [
            'field' => 'precoCompra',
            'label' => 'Preço de Compra',
            'rules' => 'trim',
        ],
        [
            'field' => 'precoVenda',
            'label' => 'Preço de Venda',
            'rules' => 'trim',
        ],
        [
            'field' => 'estoque',
            'label' => 'Estoque',
            'rules' => 'trim',
        ],
        [
            'field' => 'estoqueMinimo',
            'label' => 'Estoque Minimo',
            'rules' => 'trim',
        ]
    ],
];
