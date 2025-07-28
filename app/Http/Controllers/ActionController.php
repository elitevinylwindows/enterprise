<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Services\RingCentralService;


class ActionController extends Controller
{
   public function sendTemplate($id, $template_id)
{
    $delivery = Delivery::find($id);
    $template = Template::find($template_id);

    if (!$delivery || !$template || !$template->enabled_email) {
        return response()->json(['message' => 'Invalid template or delivery record'], 400);
    }

        $shortcodes = [
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
            '{{ address }}' => $delivery->address,
            '{{ timeframe }}' => $delivery->timeframe,
            '{{ contact_phone }}' => $delivery->contact_phone,
            '{{ status }}' => $delivery->status,
            
        ];

        $message = str_replace(array_keys($shortcodes), array_values($shortcodes), $template->message);

        $recipient = $delivery->customer_email;

if (!$recipient) {
    return back()->with('error', 'Customer email not set.');
}

$user = Auth::user(); // get logged-in user

Mail::raw($message, function ($mail) use ($template, $recipient, $user) {
    $mail->to($recipient)
         ->from($user->email, $user->name)
         ->subject($template->subject);
});


    return redirect()->back()->with('success', 'Email sent.');
    }
    

public function makeCall($id)
{
    $delivery = Delivery::findOrFail($id);

    $rc = new RingCentralService();

    $from = auth()->user()->phone ?? env('RC_USERNAME');
    $to = $delivery->contact_phone ?? $delivery->customer_phone;

    if (!$to) {
        return back()->with('error', 'Recipient phone number missing.');
    }

    try {
        $rc->initiateCall($from, $to);
        return back()->with('success', 'Call initiated via RingCentral.');
    } catch (\Exception $e) {
        \Log::error('RingCentral Call Error: ' . $e->getMessage());
        return back()->with('error', 'Failed to initiate call.');
    }
}

}
