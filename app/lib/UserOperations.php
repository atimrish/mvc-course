<?php

namespace app\lib;

class UserOperations
{
    const RoleGuest = 'guest';
    const RoleAdmin = 'admin';
    const RoleUser = 'user';

    public static function getRoleUser()
    {
        $result = self::RoleGuest;
        if (isset($_SESSION['user']['id']) && $_SESSION['user']['is_admin']) {
            $result = self::RoleAdmin;
        } elseif (isset($_SESSION['user']['id'])) {
            $result = self::RoleUser;
        }
        return $result;
    }

    public static function getMenuLinks()
    {
        $role = self::getRoleUser();
        $list[] = [
            'title' => 'Мой профиль',
            'link' => '/user/profile'
        ];
        $list[] = [
            'title' => 'Главная',
            'link' => '/main/index'
        ];

        if ($role === self::RoleUser) {
            $list[] = [
                'title' => 'Корзина',
                'link' => '/basket/list'
            ];
        }

        if ($role === self::RoleAdmin) {
            $list[] = [
                'title' => 'Пользователи',
                'link' => '/user/users'
            ];
        }

        if ($role === self::RoleAdmin) {
            $list[] = [
                'title' => 'Приход товаров',
                'link' => '/arrival/add'
            ];
        }

        $list[] = [
            'title' => 'Продукты',
            'link' => '/products/list'
        ];

        $list[] = [
            'title' => 'Выход',
            'link' => '/user/logout'
        ];

        return $list;

    }
}




