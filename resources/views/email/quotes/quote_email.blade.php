<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>
    </title>
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
                        <td class="header" style="background-color: #a80000; padding: 40px; text-align: center; color: white; font-size: 24px;">
                            <img src="{{ asset(Storage::url('upload/logo/')) . '/logo.png' }}" style="height: 100px;" alt="">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="body532" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                            <h2>{{ __('Your Quotation is Ready') }}</h2>

                            <p>{{ __('Dear') }} {{ $name }},</p>

                            <p>
                                {{ __('Thank you for your interest in') }} <strong>{{ env('APP_NAME') }}</strong>.
                                {{ __('Your quotation is now ready. Please review the details below and take action.') }}
                            </p>

                            {{-- Quotation Summary --}}
                            <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Quotation Number') }}:</td>
                                    <td style="padding: 8px;">{{ $quote->quote_number }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Date') }}:</td>
                                    <td style="padding: 8px;">{{ $quote->entry_date }}</td>
                                </tr>

                                <tr>
                                    <td style="padding: 8px; font-weight: bold;">{{ __('Expiry Date') }}:</td>
                                    <td style="padding: 8px;">{{ $quote->valid_until }}</td>
                                </tr>
                            </table>

                            {{-- Action Button --}}
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $url }}" class="button" target="_blank" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 6px;">
                                    {{ __('View & Respond to Quotation') }}
                                </a>
                            </p>

                            <p>{{ __('If the button above doesn’t work, you can also access the quotation directly using the link below:') }}</p>
                            <p><a href="{{ $url }}" target="_blank">{{ $url }}</a></p>

                            <p>{{ __('You can approve or decline the quotation from the link provided. We’re looking forward to your response.') }}</p>
                            <p>{{ __('If you have any questions, feel free to reach out to our team.') }}</p>

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
