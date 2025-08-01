<?php

namespace App\Controllers;
use App\Models\MenuModel;

class Menu extends BaseController
{
    public function index()
    {
        $model = new MenuModel();
        $menus = $model->findAll();
        $kategori = array_unique(array_column($menus, 'kategori'));

        return view('menu/index', [
            'menus' => $menus,
            'kategori' => $kategori,
            'restoName' => 'Depot Makan',
            'restoDescription' => 'Makanan enak, suasana nyaman.'
        ]);
    }
}
