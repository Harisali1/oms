<?php

namespace App\Services\Menu;

use Illuminate\Support\Facades\Auth;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

/**
 * Class AdminMenu
 *
 * @author Muzafar Ali Jatoi <muzfr7@gmail.com>
 * @date   23/9/18
 */
class AdminMenu
{
    public function register()
    {
        Menu::macro('admin', function () {
            /*getting user permissions*/

            $userPermissoins = Auth::user()->getPermissions();

            return Menu::new()

                ->addClass('page-sidebar-menu')
                ->setAttribute('data-keep-expanded', 'false')
                ->setAttribute('data-auto-scroll', 'true')
                ->setAttribute('data-slide-speed', '200')
                ->html('<div class="sidebar-toggler hidden-phone"></div>')

                ->add(Link::toRoute(
                    'dashboard.index',
                    '<i class="fa fa-home"></i> <span class="title">Dashboard</span>'
                )
                ->addParentClass('start'))




                ->add(Link::toRoute(
                    'logout',
                    '<i class="fa fa-sign-out"></i> <span class="title">Logout</span>'
                )
                    ->setAttribute('id', 'leftnav-logout-link'))
                ->setActiveFromRequest();
        });
    }
}
