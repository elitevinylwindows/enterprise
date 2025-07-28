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
                <table class="content" width="600" border="0" cellspacing="0" cellpadding="0"
                    style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <!-- Header -->
                    <tr>
                        <td class="header"
                            style="background-color: #345C72; padding: 40px; text-align: center; color: white; font-size: 24px;">
                            <img src="{{ asset(Storage::url('upload/logo/')) . '/logo.png' }}" style="height: 100px;"
                                alt="">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="body532" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                            <h2>{{ __('Verify Your Email Address') }}</h2>
                            <p>{{ __('Dear') }} {{ $data['name'] }},</p>
                            <p>{{ __('Thank you for signing up with') }} <strong>{{ env('APP_NAME') }}</strong>.
                                {{ __('To complete your registration, please confirm your email address by clicking the button below:') }}</p>
                            <p style="text-align: center;">
                                <a href="{{ $data['url'] }}" class="button" target="_blank">{{ __('Verify Email Address') }}</a>
                            </p>
                            <p>{{ __('If the button above doesn’t work, copy and paste this URL into your web browser:') }}</p>
                            <p><a href="{{ $data['url'] }}">{{ $data['url'] }}"></a></p>
                            <p>{{ __('This link will expire in 60 minutes.') }}</p>
                            <p>{{ __('If you didn’t create this account, you can safely ignore this email.') }}</p>
                            <div class="footer">
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
