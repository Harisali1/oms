<?php


/**
 * Permissions config
 *
 * @author Muhammad Adnan <adnannadeem1994@gmail.com>
 * @date   23/10/2020
 */

return [
    'Roles'=>
        [
            'List' => 'role.index',
            'Create' => 'role.create|role.store',
            'Edit' => 'role.edit|role.update',
            'View' => 'role.show',
            'Set Permissions' => 'role.set-permissions|role.set-permissions.update',
        ],

    'Sub Admin'=>
        [
            'List' => 'sub-admin.index|sub-admin.data',
            'Create' => 'sub-admin.create|sub-admin.store',
            'Edit' => 'sub-admin.edit|sub-admin.update',
            'Status Change' => 'sub-admin.active|sub-admin.inactive',
            'Delete' => 'sub-admin.destroy',
        ],

    'Control'=>
        [
            'Delivery Type List' => 'delivery_type.index',
            'Delivery Type Create' => 'delivery_type.create|delivery_type.store',
            'Delivery Type Edit' => 'delivery_type.edit|delivery_type.update',
            'Delivery Type Delete' => 'delivery_type.destroy',
            'Delivery Preference List' => 'delivery_preference.index',
            'Delivery Preference Create' => 'delivery_preference.create|delivery_preference.store',
            'Delivery Preference Edit' => 'delivery_preference.edit|delivery_preference.update',
            'Delivery Preference Delete' => 'delivery_preference.destroy',
            'Order Category List' => 'order_category.index',
            'Order Category Create' => 'order_category.create|order_category.store',
            'Order Category Edit' => 'order_category.edit|order_category.update',
            'Order Category Delete' => 'order_category.destroy',
        ],

    'Routes'=>
        [
            'Joey Routes List' => 'joey.route.index',
            'Joey Route Map' => 'job.route',
            'Make Route' => 'job.routes'
        ],

    'Schedule' => [
        'List' => 'schedule.index',
        'Create' => 'schedule.create|schedule.store',
        'Edit' => 'schedule.edit|schedule.update',
        'Delete' => 'schedule.destroy',
        'Search' => 'schedule.search',
        'Shift Publisher List' => 'shift.publisher.index',
    ],

    'Grocery Dispatch' => [
        'Grocery' => 'Grocery-Dispatch|Grocery-Dispatch.data|open.modals',
        'Map-View' => 'E-Commerce-Dispatch',
        'Map-Filter' => 'dispatch.map.view',
        'Assign Order' => 'assign.order',
        'Transfer Order' => 'transfer.order',
        'Edit Order' => 'edit.order',
        'ReBroadCast Order' => 'rebroadcast.order',
        'Pre BroadCast Order' => 'pre.broadcast.order',
        'Cancel Order' => 'sprint.cancel',
        'Order Map' => 'order.map',
        'Order Note' => 'order.note',
        'Order Notes' => 'order.notes',
        'Order Detail' => 'order.detail',
        'Update Order' => 'order.sprint.update',
        'Order Task Update' => 'order.sprint.task.update',
    ],
    'Batch Orders'=>
        [
            'Batch'=>'create.batch',
            'Batch Orders' => 'batch-order.index',
            'Batch Create' => 'batch-create-model-html-render',
            'Batch Assign'=>'assign.batch.joey',
            'Batch update'=>'create.batch.assign',
            'Batch Transfer to joey'=>'transfer.batch.joey',
            'Batch Transfer'=> 'transfer.batch',
            'Edit Batch'=>'edit.assign.batch',
            'Update Batch'=>'edit-batch.update',
            'UnAssigned Batch'=>'Unassigned.batch',
            'Batch Map-View'=>'map.view',
        ],
];
