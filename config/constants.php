<?php

// User Types
const USER_TYPE_ADMIN = 1;
const USER_TYPE_CLIENT = 2;
const USER_TYPE_SHIPPING_COMPANY = 3;

// Statuses
const STATUS_DISABLED = 0;
const STATUS_ENABLED = 1;

// // Routes
const ROUTE_TYPE_SEA = 1;
const ROUTE_TYPE_LAND = 2;
const ROUTE_TYPE_AIR = 3;

return [
    'IGNORED_COMPANIES' => [
        env('MAERSK_COMPANY_ID'),
        env('CMA_COMPANY_ID'),
        env('HAPAG_COMPANY_ID'),
        env('MSC_COMPANY_ID')
    ],

    'MAERSK_COMPANY_ID' => env('MAERSK_COMPANY_ID'),

    'BOOKING_STATUS_IN_PROGRESS' => 1,
    'BOOKING_STATUS_COMPLETED' => 2,
    'BOOKING_STATUS_ON_HOLD' => 3,
    'BOOKING_STATUS_CANCELLED' => 4,

    'WORK_WITH_US_FORM_STATUS_PENDING' => 1,
    'WORK_WITH_US_FORM_STATUS_ACCEPTED' => 2,
    'WORK_WITH_US_FORM_STATUS_REJECTED' => 3,


    //addons active/inactive status
    'ADDON_BOOKING_STATUS_INACTIVE' => 0,
    'ADDON_BOOKING_STATUS_ACTIVE' => 1,


    //Booking payment status
    'BOOKING_PAYMENT_STATUS_ON_HOLD' => 1,

     // Company docs type
    'COMPANY_DOCUMENTS' =>[
                    (object) [ 'value' => 1, 'label' => 'Shipping License'],
                    (object) [ 'value' => 2, 'label' => 'VAT Certificate'],
    ],

    // Company registration status
    'COMPANY_REGISTRATION_STATUS_PENDING' => 1,
    'COMPANY_REGISTRATION_STATUS_APPROVED' => 2,
    'COMPANY_REGISTRATION_STATUS_RESUBMIT' => 3,
    'COMPANY_REGISTRATION_STATUS_REJECTED' => 4,

    'COMPANY_STATUSES' => [
        'COMPANY_REGISTRATION_STATUS_PENDING' => [
            'value' => 1,
            'label' => 'PENDING',
        ],
        'COMPANY_REGISTRATION_STATUS_APPROVED' => [
            'value' => 2,
            'label' => 'APPROVED',
        ],
        'COMPANY_REGISTRATION_STATUS_RESUBMIT' => [
            'value' => 3,
            'label' => 'RESUBMIT',
        ],
        'COMPANY_REGISTRATION_STATUS_REJECTED' => [
            'value' => 4,
            'label' => 'REJECTED',
        ]
    ],


    //user role
    'USER_TYPE_SUPERADMIN' => 1,
    'USER_TYPE_CUSTOMER' => 2,
    'USER_TYPE_MANAGER' => 3,
    'USER_TYPE_SUPPLIER' => 4,
    'USER_TYPE_SHIPPER' => 4,

    'COMPANY_BUSINESS_TYPE' => [
        (object) ['value' => 'insurance', 'label' => 'Insurance'],
        (object) ['value' => 'preshipment-inspection', 'label' => 'Pre Shipment Inspection Service'],
        (object) ['value' => 'clearance-agent', 'label' => 'Clearance Agent'],
        (object) ['value' => 'sea-transport', 'label' => 'Sea Transporter'],
        (object) ['value' => 'land-transport', 'label' => 'Land Transporter'],
        (object) ['value' => 'air-transport', 'label' => 'Air Transporter'],
    ],
   
    'EMPLOYEE_POSITIONS' => [
        (object) ['value' => 'Customer Service Coordinator', 'label' => 'Customer Service Coordinator'],
        (object) ['value' => 'Finance Coordinator', 'label' => 'Finance Coordinator'],
        (object) ['value' => 'Matter Expert', 'label' => 'Matter Expert'],
    ],
];
