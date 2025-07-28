<?php

namespace App\Helpers;

class ShortcodeHelper
{
    public static function getShortcodesForTemplate(array $models): array
    {
        $shortcodes = [];

        foreach ($models as $model) {
            if ($model instanceof \App\Models\Order) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ order }}' => $model->order ?? '',
                    '{{ customer }}' => $model->customer ?? '',
                    '{{ customer_name }}' => $model->customer_name ?? '',
                    '{{ customer_short_name }}' => $model->customer_short_name ?? '',
                    '{{ units }}' => $model->units ?? '',
                    '{{ comment }}' => $model->comment ?? '',
                    '{{ delivery_date }}' => $model->delivery_date ?? '',
                    '{{ area }}' => $model->area ?? '',
                    '{{ of_fields }}' => $model->of_fields ?? '',
                    '{{ archived }}' => $model->archived ?? '',
                    '{{ arrival_date }}' => $model->arrival_date ?? '',
                    '{{ arrival_variation }}' => $model->arrival_variation ?? '',
                    '{{ canceled }}' => $model->canceled ?? '',
                    '{{ city }}' => $model->city ?? '',
                    '{{ classification }}' => $model->classification ?? '',
                    '{{ commercial_site }}' => $model->commercial_site ?? '',
                    '{{ complete_receipt }}' => $model->complete_receipt ?? '',
                    '{{ completed }}' => $model->completed ?? '',
                    '{{ completely_invoiced }}' => $model->completely_invoiced ?? '',
                    '{{ created_at }}' => $model->created_at ?? '',
                    '{{ credit_limit_block }}' => $model->credit_limit_block ?? '',
                    '{{ credit_note_exists }}' => $model->credit_note_exists ?? '',
                    '{{ currency }}' => $model->currency ?? '',
                    '{{ cw }}' => $model->cw ?? '',
                    '{{ dealer }}' => $model->dealer ?? '',
                    '{{ delivery_condition }}' => $model->delivery_condition ?? '',
                    '{{ delivery_date_calc_mode }}' => $model->delivery_date_calc_mode ?? '',
                    '{{ delivery_note_exists }}' => $model->delivery_note_exists ?? '',
                    '{{ delivery_note_printed }}' => $model->delivery_note_printed ?? '',
                    '{{ deposit_invoice_exists }}' => $model->deposit_invoice_exists ?? '',
                    '{{ dispatch_planned }}' => $model->dispatch_planned ?? '',
                    '{{ edit_status }}' => $model->edit_status ?? '',
                    '{{ end_of_appeal_period }}' => $model->end_of_appeal_period ?? '',
                    '{{ entered_by }}' => $model->entered_by ?? '',
                    '{{ entry_date }}' => $model->entry_date ?? '',
                    '{{ entry_date_original }}' => $model->entry_date_original ?? '',
                    '{{ external_manufacturing }}' => $model->external_manufacturing ?? '',
                    '{{ external_reference_order }}' => $model->external_reference_order ?? '',
                    '{{ factory_assignment_undefined }}' => $model->factory_assignment_undefined ?? '',
                    '{{ id_display }}' => $model->id_display ?? '',
                    '{{ import_assignment }}' => $model->import_assignment ?? '',
                    '{{ in_house_manufacturing }}' => $model->in_house_manufacturing ?? '',
                    '{{ input_type }}' => $model->input_type ?? '',
                    '{{ inside_sales }}' => $model->inside_sales ?? '',
                    '{{ installation_service_scheduled }}' => $model->installation_service_scheduled ?? '',
                    '{{ installation_area }}' => $model->installation_area ?? '',
                    '{{ internal_invoice_exists }}' => $model->internal_invoice_exists ?? '',
                    '{{ internal_order }}' => $model->internal_order ?? '',
                    '{{ internal_order_number }}' => $model->internal_order_number ?? '',
                    '{{ invoice_exists }}' => $model->invoice_exists ?? '',
                    '{{ invoice_has_been_paid }}' => $model->invoice_has_been_paid ?? '',
                    '{{ invoice_printed }}' => $model->invoice_printed ?? '',
                    '{{ is_delivery }}' => $model->is_delivery ?? '',
                    '{{ manual_lock }}' => $model->manual_lock ?? '',
                    '{{ max_arrival_date_delivery_note }}' => $model->max_arrival_date_delivery_note ?? '',
                    '{{ min_arrival_date_delivery_note }}' => $model->min_arrival_date_delivery_note ?? '',
                    '{{ name }}' => $model->name ?? '',
                    '{{ name_2 }}' => $model->name_2 ?? '',
                    '{{ net_price }}' => $model->net_price ?? '',
                    '{{ net_price_in_own_currency }}' => $model->net_price_in_own_currency ?? '',
                    '{{ number_of_fields }}' => $model->number_of_fields ?? '',
                    '{{ object_type }}' => $model->object_type ?? '',
                    '{{ order_commercial_site }}' => $model->order_commercial_site ?? '',
                    '{{ order_complete }}' => $model->order_complete ?? '',
                    '{{ order_confirmation_printed }}' => $model->order_confirmation_printed ?? '',
                    '{{ order_number }}' => $model->order_number ?? '',
                    '{{ order_type }}' => $model->order_type ?? '',
                    '{{ origin }}' => $model->origin ?? '',
                    '{{ outside_sales }}' => $model->outside_sales ?? '',
                    '{{ payment_method }}' => $model->payment_method ?? '',
                    '{{ print_date }}' => $model->print_date ?? '',
                    '{{ prod_status_color }}' => $model->prod_status_color ?? '',
                    '{{ production }}' => $model->production ?? '',
                    '{{ production_site }}' => $model->production_site ?? '',
                    '{{ production_status }}' => $model->production_status ?? '',
                    '{{ production_status_color }}' => $model->production_status_color ?? '',
                    '{{ project }}' => $model->project ?? '',
                    '{{ project_number }}' => $model->project_number ?? '',
                    '{{ purchase_order_date }}' => $model->purchase_order_date ?? '',
                    '{{ reference }}' => $model->reference ?? '',
                    '{{ required_date }}' => $model->required_date ?? '',
                    '{{ required_date_cw }}' => $model->required_date_cw ?? '',
                    '{{ schedule_status }}' => $model->schedule_status ?? '',
                    '{{ scheduling }}' => $model->scheduling ?? '',
                    '{{ shipping_stages }}' => $model->shipping_stages ?? '',
                    '{{ short_name }}' => $model->short_name ?? '',
                    '{{ status }}' => $model->status ?? '',
                    '{{ status_code }}' => $model->status_code ?? '',
                    '{{ tax }}' => $model->tax ?? '',
                    '{{ tax_rule }}' => $model->tax_rule ?? '',
                    '{{ tech_handling }}' => $model->tech_handling ?? '',
                    '{{ total_in_own_currency }}' => $model->total_in_own_currency ?? '',
                    '{{ total_in_row }}' => $model->total_in_row ?? '',
                    '{{ total_including }}' => $model->total_including ?? '',
                    '{{ total_including_tax }}' => $model->total_including_tax ?? '',
                    '{{ updated_at }}' => $model->updated_at ?? '',
                    '{{ validity_date }}' => $model->validity_date ?? '',
                    '{{ waiting_for_change_order }}' => $model->waiting_for_change_order ?? '',
                    '{{ waiting_for_secondary_plant }}' => $model->waiting_for_secondary_plant ?? '',
                    '{{ window_order_printed_exported }}' => $model->window_order_printed_exported ?? '',
                    '{{ zip }}' => $model->zip ?? '',
                ]);
            }

            if ($model instanceof \App\Models\Delivery) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ delivery_address }}' => $model->address ?? '',
                    '{{ delivery_timeframe }}' => $model->timeframe ?? '',
                    '{{ delivery_contact_phone }}' => $model->contact_phone ?? '',
                    '{{ delivery_carts }}' => $model->carts ?? '',
                    '{{ delivery_units }}' => $model->units ?? '',
                    '{{ delivery_status }}' => $model->status ?? '',
                ]);
            }

            if ($model instanceof \App\Models\Cart) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ cart_barcode }}' => $model->cart_barcode ?? '',
                    '{{ production_barcode }}' => $model->production_barcode ?? '',
                    '{{ cart_width }}' => $model->width ?? '',
                    '{{ cart_height }}' => $model->height ?? '',
                ]);
            }

            if ($model instanceof \App\Models\Truck) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ truck_id }}' => $model->truck_id ?? '',
                    '{{ truck_model }}' => $model->model ?? '',
                    '{{ truck_capacity }}' => $model->capacity ?? '',
                    '{{ truck_license_plate }}' => $model->license_plate ?? '',
                ]);
            }

            if ($model instanceof \App\Models\Route) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ route_name }}' => $model->route_name ?? '',
                    '{{ start_location }}' => $model->start_location ?? '',
                    '{{ end_location }}' => $model->end_location ?? '',
                ]);
            }

            if ($model instanceof \App\Models\User) {
                $shortcodes = array_merge($shortcodes, [
                    '{{ user_name }}' => $model->name ?? '',
                    '{{ user_email }}' => $model->email ?? '',
                    '{{ user_phone }}' => $model->phone_number ?? '',
                    '{{ user_type }}' => $model->type ?? '',
                    '{{ user_lang }}' => $model->lang ?? '',
                    '{{ user_subscription }}' => $model->subscription ?? '',
                    '{{ user_status }}' => $model->is_active ? 'Active' : 'Inactive',
                ]);
            }
        }

        return $shortcodes;
    }
    
    
    public static function getAvailableShortcodeList(): array
{
    return [
        // Order
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
        '{{ window_order_printed_exported }}', '{{ zip }}',

        // Delivery
        '{{ delivery_address }}', '{{ delivery_timeframe }}', '{{ delivery_contact_phone }}',
        '{{ delivery_carts }}', '{{ delivery_units }}', '{{ delivery_status }}',

        // Cart
        '{{ cart_barcode }}', '{{ production_barcode }}', '{{ cart_width }}', '{{ cart_height }}',

        // Truck
        '{{ truck_id }}', '{{ truck_model }}', '{{ truck_capacity }}', '{{ truck_license_plate }}',

        // Route
        '{{ route_name }}', '{{ start_location }}', '{{ end_location }}',

        // User
        '{{ user_name }}', '{{ user_email }}', '{{ user_phone }}', '{{ user_type }}',
        '{{ user_lang }}', '{{ user_subscription }}', '{{ user_status }}',
    ];
}


public static function getShortcodeGroups()
{
    return [
        'Order' => array_keys(self::getShortcodesForTemplate(new \App\Models\Order)),
        'Delivery' => array_keys(self::getShortcodesForTemplate(new \App\Models\Delivery)),
        'Cart' => array_keys(self::getShortcodesForTemplate(new \App\Models\Cart)),
        'Route' => array_keys(self::getShortcodesForTemplate(new \App\Models\Route)),
        'Truck' => array_keys(self::getShortcodesForTemplate(new \App\Models\Truck)),
        'User' => array_keys(self::getShortcodesForTemplate(new \App\Models\User)),
    ];
}



}
