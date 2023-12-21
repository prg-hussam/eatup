<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('emails.reset_password.title')</title>

    <style>
        body {
            margin: 0
        }
    </style>
</head>

<body>
    <table class="body-wrap"
        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #edf2f7; margin: 0;">
        <tbody>
            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                    valign="top"></td>
                <td class="container"
                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                    width="600" valign="top">
                    <div class="content"
                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                        <table class="main" itemprop="action" itemscope=""
                            itemtype="http://schema.org/ConfirmAction"
                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
                            width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                    <td class="content-wrap"
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;"
                                        valign="top">
                                        <meta itemprop="name" content="Confirm Email"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <table
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"
                                            width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                                        valign="top">
                                                        <div style="text-align: center;margin-bottom: 15px;">
                                                            <img src="https://themesbrand.com/velzon/html/material/assets/images/logo-light.png"
                                                                alt="" height="23">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                                        valign="top">
                                                        <h4
                                                            style="font-family: 'Roboto', sans-serif; margin-top:5px; margin-bottom: 0px;font-weight: 500; line-height: 1.5;">
                                                            @lang('emails.reset_password.title')</h4>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                                        valign="top">
                                                        <h4
                                                            style="margin-top: 5px;  font-family: 'Roboto', sans-serif; margin-bottom: 0px;font-weight: 500; line-height: 1.5;">
                                                            {{ $helloUser }}</h4>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px; text-align: center;"
                                                        valign="top">
                                                        <p style="margin-bottom: 13px; line-height: 1.5;">
                                                            @lang('emails.reset_password.message')</p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block" itemprop="handler" itemscope=""
                                                        itemtype="http://schema.org/HttpActionHandler"
                                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 22px; text-align: center;"
                                                        valign="top">
                                                        <a href="{{ $url }}" itemprop="url"
                                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem; color: #FFF; text-decoration: none; font-weight: 400; text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #4b38b3; margin: 0; border-color: #4b38b3; border-style: solid; border-width: 1px; padding: .5rem .9rem;box-shadow: 0 3px 3px rgba(56,65,74,0.1);">@lang('emails.reset_password.reset_password')</a>
                                                    </td>
                                                </tr>

                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px; text-align: center;"
                                                        valign="top">
                                                        <p style="margin-bottom: 0px; line-height: 1.5;">
                                                            {{ $expire_message }}</p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="margin-top: 0px; font-weight: 500; font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px; text-align: center;"
                                                        valign="top">
                                                        <p style="line-height: 1.5;">
                                                            @lang('emails.reset_password.no_action_required')</p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block"
                                                        style="margin-top: 0px; font-weight: 500; font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px; text-align: center;"
                                                        valign="top">
                                                        <p style="margin-bottom: 0px; margin-top:0; line-height: 1.5;">
                                                            @lang('emails.regards')</p>
                                                        <p style="margin-top: 5px; margin-bottom:0; line-height: 1.5;">
                                                            {{ $appName }}</p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;">
                                                    <td class="content-block"
                                                        style="color: #878a99; text-align: center;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;"
                                                        valign="top">
                                                        <hr style="border: 1px solid #e8e5ef;">
                                                        <p>@lang('emails.reset_password.having_trouble')</p>
                                                        <p><a href="{{ $url }}"
                                                                target="_blank">{{ $url }}</a></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="text-align: center; margin: 28px auto 0px auto;">
                            <h4>@lang('emails.need_help')</h4>
                            <p style="color: #878a99;">@lang('emails.need_help_message')&nbsp;<a href="mailto:{{ $appEmail }}"
                                    style="font-weight: 500px;">{{ $appEmail }}</a></p>
                            <p style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">
                                {!! getCopyrightText() !!}</p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
