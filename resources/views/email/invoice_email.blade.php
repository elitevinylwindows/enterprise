<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ __('Invoice Notification') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open Sans" rel="stylesheet" type="text/css">

    <style>
        .body532 blockquote {
            border-left: 5px solid #ccc;
            font-style: italic;
            margin-left: 0;
            margin-right: 0;
            overflow: hidden;
            padding-left: 1.5em;
            padding-right: 1.5em;
        }

        .button {
            background-color: #345C72;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>

<body style="font-family: 'Poppins', Arial, sans-serif">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <table class="content" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <!-- Header -->
                    <tr>
                        <td class="header" style="background-color: #345C72; padding: 40px; text-align: center; color: white; font-size: 24px;">
                            <img src="{{ asset(Storage::url('upload/logo/')) . '/logo.png' }}" style="height: 100px;" alt="">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="body532" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                            <h2>{{ __('Your Invoice is Ready') }}</h2>

                            <p>{{ __('Dear') }} {{ $invoice->customer->customer_name }},</p>

                            <p>
                                {{ __('Thank you for choosing') }} <strong>{{ env('APP_NAME') }}</strong>.
                                {{ __('Your invoice has been generated. Please review the details below and proceed with the payment at your earliest convenience.') }}
                            </p>

                            {{-- Invoice Summary --}}
                            <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Invoice Number') }}:</td>
                                    <td style="padding: 8px;">{{ $invoice->invoice_number }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Invoice Date') }}:</td>
                                    <td style="padding: 8px;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Due Date') }}:</td>
                                    <td style="padding: 8px;">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Total Amount') }}:</td>
                                    <td style="padding: 8px;">{{ number_format($invoice->total, 2) }}</td>
                                </tr>
                            </table>

                            {{-- Payment Button --}}
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $invoice->payment_link }}" class="button" target="_blank" style="display: inline-block; padding: 12px 24px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 6px;">
                                    {{ __('Pay Invoice Now') }}
                                </a>
                            </p>

                            <p>{{ __('If the button above doesn’t work, you can also access the invoice directly using the link below:') }}</p>
                            <p><a href="{{ $invoice->payment_link }}" target="_blank">{{ $invoice->payment_link }}</a></p>

                            <p>{{ __('Please make the payment by the due date to avoid any late charges. If you have any questions, feel free to contact our support team.') }}</p>

                            {{-- Footer --}}
                            <div class="footer" style="margin-top: 30px;">
                                <p>{{ __('Thank you,') }}</p>
                                <p>{{ __('The') }} {{ env('APP_NAME') }} {{ __('Team') }}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
