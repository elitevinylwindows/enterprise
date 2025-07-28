<?php

namespace App\Helper;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\Cart;
use App\Models\Truck;
use App\Models\Route;
use App\Models\User;


class ShortcodeHelper
{
    public static function getShortcodeGroups()
    {
        return [
            'Order' => [
   '{{ order }}', '{{ customer }}', '{{ customer_name }}', '{{ customer_short_name }}', '{{ units }}', '{{ comment }}',
        '{{ delivery_date }}', '{{ area }}', '{{ of_fields }}', '{{ archived }}', '{{ arrival_date }}', '{{ arrival_variation }}',
        '{{ canceled }}', '{{ city }}', '{{ classification }}', '{{ commercial_site }}', '{{ complete_receipt }}',
        '{{ completed }}', '{{ completely_invoiced }}', '{{ created_at }}', '{{ credit_limit_block }}', '{{ credit_note_exists }}',
        '{{ currency }}', '{{ cw }}', '{{ dealer }}', '{{ delivery_condition }}', '{{ delivery_date_calc_mode }}',
        '{{ delivery_note_exists }}', '{{ delivery_note_printed }}', '{{ deposit_invoice_exists }}', '{{ dispatch_planned }}',
        '{{ edit_status }}', '{{ end_of_appeal_period }}', '{{ entered_by }}', '{{ entry_date }}', '{{ entry_date_original }}',
        '{{ external_manufacturing }}', '{{ external_reference_order }}', '{{ factory_assignment_undefined }}', '{{ id_display }}',
        '{{ import_assignment }}', '{{ in_house_manufacturing }}', '{{ input_type }}', '{{ inside_sales }}',
        '{{ installation_service_scheduled }}', '{{ installation_area }}', '{{ internal_invoice_exists }}', '{{ internal_order }}',
        '{{ internal_order_number }}', '{{ invoice_exists }}', '{{ invoice_has_been_paid }}', '{{ invoice_printed }}',
        '{{ is_delivery }}', '{{ manual_lock }}', '{{ max_arrival_date_delivery_note }}', '{{ min_arrival_date_delivery_note }}',
        '{{ name }}', '{{ name_2 }}', '{{ net_price }}', '{{ net_price_in_own_currency }}', '{{ number_of_fields }}',
        '{{ object_type }}', '{{ order_commercial_site }}', '{{ order_complete }}', '{{ order_confirmation_printed }}',
        '{{ order_number }}', '{{ order_type }}', '{{ origin }}', '{{ outside_sales }}', '{{ payment_method }}', '{{ print_date }}',
        '{{ prod_status_color }}', '{{ production }}', '{{ production_site }}', '{{ production_status }}',
        '{{ production_status_color }}', '{{ project }}', '{{ project_number }}', '{{ purchase_order_date }}', '{{ reference }}',
        '{{ required_date }}', '{{ required_date_cw }}', '{{ schedule_status }}', '{{ scheduling }}', '{{ shipping_stages }}',
        '{{ short_name }}', '{{ status }}', '{{ status_code }}', '{{ tax }}', '{{ tax_rule }}', '{{ tech_handling }}',
        '{{ total_in_own_currency }}', '{{ total_in_row }}', '{{ total_including }}', '{{ total_including_tax }}',
        '{{ updated_at }}', '{{ validity_date }}', '{{ waiting_for_change_order }}', '{{ waiting_for_secondary_plant }}',
        '{{ window_order_printed_exported }}', '{{ zip }}'
            ],
            
            'Delivery' => [
                '{{ address }}', '{{ timeframe }}', '{{ contact_phone }}',
                '{{ status }}',  '{{ city }}', '{{ truck_id }}', '{{ driver_id }}', '{{ notes }}',  '{{ units }}', '{{ units_check }}', '{{ carts }}'
            ],
            'Cart' => [
                '{{ cart_barcode }}', '{{ production_barcode }}', '{{ cart_width }}', '{{ cart_height }}'
            ],
            'Truck' => [
                '{{ truck_id }}', '{{ truck_model }}', '{{ truck_capacity }}', '{{ truck_license_plate }}'
            ],
            'Route' => [
                '{{ route_name }}', '{{ start_location }}', '{{ end_location }}'
            ],
            'User' => [
                '{{ user_name }}', '{{ user_email }}', '{{ user_phone }}', '{{ user_status }}'
            ],
        ];
    }
}
