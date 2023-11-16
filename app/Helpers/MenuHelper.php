<?php

/**
 * MenuHelper
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */

/**
 * Return if a menu has childrens
 *
 * @param object $menus
 * @param integer $menuId
 *
 * @return bool
 */
function menuHasChildren($menus, $menuId)
{
    foreach ($menus as $menu) {
        if ($menu->parent_id == $menuId) {
            return true;
        }
    }

    return false;
}
