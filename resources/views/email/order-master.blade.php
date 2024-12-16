<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>@yield('title') - {{($settings_g['title'] ?? env('APP_NAME'))}}</title>

        <!-- Start Common CSS -->
        <style type="text/css">
            body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Helvetica, arial, sans-serif;}
            #outlook a {padding:0;}
            .ExternalClass {width:100%;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
            .main-temp table td {border-collapse: collapse;}
            a.action_btn{    margin-top: 15px;padding: 7px 10px;display: inline-block;text-decoration: none;background: #276740;color: #fff !important}
            .action_btn:hover{text-decoration: none;}
        </style>
        <!-- End Common CSS -->
    </head>

    <body>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #f3f2f2;">
            <tbody>
                <tr>
                    <td>
                        <table width="600" align="center" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;margin-top: 25px;margin-bottom: 25px;border-radius: 3px;">
                            <tbody>
                                @yield('master')

                                <tr>
                                    <td style="width: 100%; text-align: center; font-style: italic; font-size: 13px; font-weight: 600; color: #666666; padding: 15px 0; border-top: 1px solid #eeeeee;background-color: #276740;">
                                        <ul class="social_links" style="margin: 0;padding:0;list-style:none">
                                            @if(Info::Settings('social', 'facebook'))
                                            <li style="display: inline-block"><a href="{{Info::Settings('social', 'facebook')}}"><img src="{{asset('img/fb.png')}}" alt="fb"></a></li>
                                            @endif
                                            @if(Info::Settings('social', 'twitter'))
                                            <li style="display: inline-block"><a href="{{Info::Settings('social', 'twitter')}}"><img src="{{asset('img/tw.png')}}" alt="tw"></a></li>
                                            @endif
                                            @if(Info::Settings('social', 'instagram'))
                                            <li style="display: inline-block"><a href="{{Info::Settings('social', 'instagram')}}"><img src="{{asset('img/instagram.png')}}" alt="instagram"></a></li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
