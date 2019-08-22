@extends('email.main_template')

@section('component')
    <?php
        $data =& $global_data;
        $customer =& $global_data['customer'];
    ?>
            <div style="background-color:transparent;">
                <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #D6E7F0;">
                    <div style="border-collapse: collapse;display: table;width: 100%;background-color:#D6E7F0;">
                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#D6E7F0"><![endif]-->
                        <!--[if (mso)|(IE)]><td align="center" width="650" style="background-color:#D6E7F0;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top:5px; padding-bottom:60px;"><![endif]-->
                        <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top; width: 650px;">
                            <div style="width:100% !important;">
                                <!--[if (!mso)&(!IE)]><!-->
                                <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:60px; padding-right: 25px; padding-left: 25px;">
                                    <!--<![endif]-->
                                    <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]-->
                                        <div style="font-size:1px;line-height:45px"></div><img align="center" alt="Image" border="0" class="center fixedwidth" src="{{$message->embed(public_path('storage/' . $data['template']['name'] . '/img/mail/welcome_background.png'))}}" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 540px; display: block;" title="Image" width="540"/>
                                        <!--[if mso]></td></tr></table><![endif]-->
                                    </div>
                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 15px; padding-top: 20px; padding-bottom: 0px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                    <div style="color:#052d3d;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:150%;padding-top:20px;padding-right:10px;padding-bottom:0px;padding-left:15px;">
                                        <div style="font-size: 12px; line-height: 18px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">
                                            <p style="font-size: 14px; line-height: 75px; text-align: center; margin: 0;"><span style="font-size: 50px;"><strong><span style="line-height: 75px; font-size: 50px;"><span style="font-size: 38px; line-height: 57px;">Добро Пожаловать</span></span></strong></span></p>
                                            <p style="font-size: 14px; line-height: 51px; text-align: center; margin: 0;"><span style="font-size: 34px;"><strong><span style="line-height: 51px; font-size: 34px;"><span style="color: #2190e3; line-height: 51px; font-size: 34px;">{{$customer->full_name}}</span></span></strong></span></p>
                                        </div>
                                    </div>
                                    <!--[if mso]></td></tr></table><![endif]-->
                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                    <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                            <p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;"><span style="font-size: 18px; color: #000000;">Спасибо за регистрацию на сайте компании {{$data['info']['company_name']}}. В ближайшее время с вами свяжется наш менеджер, уточнит всю необходимую информацию и откроет доступ к оптовым ценам.</span></p>
                                        </div>
                                    </div>
                                    <!--[if mso]></td></tr></table><![endif]-->
                                    <div align="center" class="button-container" style="padding-top:20px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <!--[if mso]>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                            <tr>
                                                <td style="padding-top: 20px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:39pt; width:171pt; v-text-anchor:middle;" arcsize="29%" stroke="false" fillcolor="#fc7318"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Tahoma, Verdana, sans-serif; font-size:16px">
                                        <![endif]-->
                                        <a href="{{env('APP_URl') . '/login'}}" style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #ffffff; background-color: #fc7318; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; width: auto; width: auto; border-top: 1px solid #fc7318; border-right: 1px solid #fc7318; border-bottom: 1px solid #fc7318; border-left: 1px solid #fc7318; padding-top: 10px; padding-bottom: 10px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;">
                                                <span style="font-size: 16px; line-height: 32px;">
                                                    <strong>Перейти на сайт</strong>
                                                </span>
                                            </span>
                                        </a>
                                        <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                                    </div>
                                    <!--[if (!mso)&(!IE)]><!-->
                                </div>
                                <!--<![endif]-->
                            </div>
                        </div>
                        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                        <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                    </div>
                </div>
            </div>
@endsection
