@extends('email.main_template')

@section('component')

    <?php
        $data =& $global_data;
        $order =& $global_data['order'];
    ?>

    <div style="background-color:transparent;">
    <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #D6E7F0;">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#D6E7F0;background-image:url({{$message->embed(public_path('storage/' . $data['template']['name'] . '/img/mail/order_background.png'))}});background-position:top center;background-repeat:no-repeat">
            <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#D6E7F0"><![endif]-->
            <!--[if (mso)|(IE)]><td align="center" width="650" style="background-color:#D6E7F0;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:60px;"><![endif]-->
            <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top; width: 650px;">
                <div style="width:100% !important;">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:55px; padding-bottom:60px; padding-right: 0px; padding-left: 0px;">
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 15px; padding-top: 20px; padding-bottom: 5px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                        <div style="color:#052d3d;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:20px;padding-right:10px;padding-bottom:5px;padding-left:15px;">
                            <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">
                                <p style="font-size: 14px; line-height: 45px; text-align: center; margin: 0;"><span style="font-size: 38px;"><strong><span style="line-height: 45px; font-size: 38px;">Спасибо за заказ!</span></strong></span></p>
                            </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                        <div style="color:#052D3D;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                            <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052D3D;">
                                <p style="font-size: 14px; line-height: 26px; text-align: center; margin: 0;"><span style="font-size: 22px;"><strong><span style="line-height: 26px; font-size: 22px;">{{$order->customer->full_name}}, меня зовут Олег, я уже начал обработку вашего заказа и свяжусь с вами в ближайшее время.</span></strong></span></p>
                            </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
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
    <div style="background-color:transparent;">
        <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
                <!--[if (mso)|(IE)]><td align="center" width="650" style="background-color:#FFFFFF;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top; width: 650px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#052d3d;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="line-height: 14px; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">
                                    <p style="line-height: 24px; text-align: center; font-size: 12px; margin: 0;"><span style="font-size: 20px;">Список товаров:</span></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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

    <!-- Таблица товаров -->
    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #F8F8F8;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#F8F8F8;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#F8F8F8"><![endif]-->
                <!--[if (mso)|(IE)]><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong>Товар</strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                <tbody>
                                <tr style="vertical-align: top;" valign="top">
                                    <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="5" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; border-top: 0px solid transparent; height: 5px;" valign="top" width="100%">
                                            <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                                <td height="5" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 15px; padding-left: 15px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong>Кол-во</strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong>Цена</strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    @foreach($order->products as $key => $product)

        <?php
            if($key % 2)
                $background_color = '#F9F9F9';
            else
                $background_color = '#FFFFFF';
        ?>

        <div style="background-color:transparent;">
            <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: {{$background_color}};">
                <div style="border-collapse: collapse;display: table;width: 100%;background-color:{{$background_color}};">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
                    <!--[if (mso)|(IE)]><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                    <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                        <div style="width:100% !important;">
                            <!--[if (!mso)&(!IE)]><!-->
                            <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                <!--<![endif]-->
                                <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]-->
                                    @if( isset($product->images[0]->name) && $product->images[0]->name !== null )
                                        <img align="center" alt="Image" border="0" class="center fixedwidth" src="{{ $message->embed(public_path('storage/' . $data['template']['name'] . '/img/shop/product/xs/' . $product->images[0]->name)) }}" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 130px; display: block;" title="Image" width="130">
                                        @endif
                                    <!--[if mso]></td></tr></table><![endif]-->
                                </div>
                                <!--[if (!mso)&(!IE)]><!-->
                            </div>
                            <!--<![endif]-->
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                    <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                    <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                        <div style="width:100% !important;">
                            <!--[if (!mso)&(!IE)]><!-->
                            <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                                <!--<![endif]-->
                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                    <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                        <p style="font-size: 14px; line-height: 16px; text-align: left; margin: 0;">
                                            <a href="{{ route('products.show', $product->id) }}" target="_blank">
                                                {{ $product->name }}
                                                @if( isset($product->pivot['order_attributes_collection']) && count( $product->pivot['order_attributes_collection'] ) > 0)

                                                    @foreach($product->pivot['order_attributes_collection'] as $attribute)
                                                        {{' ' .$attribute->name}} : {{$attribute->pivot->value}}
                                                    @endforeach

                                                @endif
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <!--[if mso]></td></tr></table><![endif]-->
                                <!--[if (!mso)&(!IE)]><!-->
                            </div>
                            <!--<![endif]-->
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                    <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                    <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                        <div style="width:100% !important;">
                            <!--[if (!mso)&(!IE)]><!-->
                            <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:55px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                <!--<![endif]-->
                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                    <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                        <p style="font-size: 14px; line-height: 24px; text-align: center; margin: 0;"><span style="font-size: 20px;"><strong>{{ $product->pivot['quantity'] }}</strong></span></p>
                                    </div>
                                </div>
                                <!--[if mso]></td></tr></table><![endif]-->
                                <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                    <tbody>
                                    <tr style="vertical-align: top;" valign="top">
                                        <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="30" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; border-top: 0px solid transparent; height: 30px;" valign="top" width="100%">
                                                <tbody>
                                                <tr style="vertical-align: top;" valign="top">
                                                    <td height="30" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--[if (!mso)&(!IE)]><!-->
                            </div>
                            <!--<![endif]-->
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                    <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                    <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                        <div style="width:100% !important;">
                            <!--[if (!mso)&(!IE)]><!-->
                            <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:55px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                <!--<![endif]-->
                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:15px;padding-bottom:0px;padding-left:0px;">
                                    <div style="line-height: 14px; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                        <p style="line-height: 24px; text-align: center; font-size: 12px; margin: 0;"><span style="font-size: 20px;"><span style="line-height: 24px; font-size: 20px;"><strong>{{ $product->price['value'] . ' ' . $data['components']['shop']['currency']['symbol']}} [{{ $product->price['value'] * $product->pivot['quantity'] . ' ' . $data['components']['shop']['currency']['symbol']}}]</strong></span></span></p>
                                    </div>
                                </div>
                                <!--[if mso]></td></tr></table><![endif]-->
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
    @endforeach
    <div style="background-color:transparent;">
        <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
                <!--[if (mso)|(IE)]><td align="center" width="650" style="background-color:#FFFFFF;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top; width: 650px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#052d3d;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="line-height: 14px; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">
                                    <p style="line-height: 24px; text-align: center; font-size: 12px; margin: 0;"><span style="font-size: 20px;">Итого: <b>{{ $order->total . " " . $data['components']['shop']['currency']['symbol']}}</b></span></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    <!-- Конец Таблицы товаров -->

    <!-- Данные Заказа -->
    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #F8F8F8;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#F8F8F8;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#F8F8F8"><![endif]-->
                <!--[if (mso)|(IE)]><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong>Данные покупателя</strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                <tbody>
                                <tr style="vertical-align: top;" valign="top">
                                    <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="5" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; border-top: 0px solid transparent; height: 5px;" valign="top" width="100%">
                                            <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                                <td height="5" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:15px; padding-bottom:5px; padding-right: 15px; padding-left: 15px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong>Данные о заказе</strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#F8F8F8;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: center; margin: 0;"><strong></strong></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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

    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                <!--[if (mso)|(IE)]>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                        <tr>
                            <td align="center">
                                <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                    <tr class="layout-full-width" style="background-color:#FFFFFF">
                <![endif]-->
                <!--[if (mso)|(IE)]>
                    <td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>ФИО Получателя:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->customer->full_name}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>Способ оплаты:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->payment->name}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #F9F9F9;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#F9F9F9;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                <tr class="layout-full-width" style="background-color:#FFFFFF">
                <![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>Телефон:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->customer->phone}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>Статус оплаты:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        @if($order->paid) Оплачен @else Не оплачен @endif
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                <tr class="layout-full-width" style="background-color:#FFFFFF">
                <![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>E-Mail:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->customer->email}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>Способ доставки:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->shipment->name}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    <div style="background-color:transparent;">
        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #F9F9F9;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#F9F9F9;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                <tr class="layout-full-width" style="background-color:#FFFFFF">
                <![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; margin: 0;">
                                        <strong>Адрес покупателя:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->customer->address}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        <strong>Адрес доставки:</strong>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                <div style="font-size: 12px; line-height: 14px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555;">
                                    <p style="font-size: 14px; line-height: 16px; text-align: left; padding-left:5px; margin: 0;">
                                        {{$order->delivery_address}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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
    <!-- Конец Данных о заказе -->

    <!-- Комментарий к заказу -->
    <div style="background-color:transparent;">
        <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
                <!--[if (mso)|(IE)]><td align="center" width="650" style="background-color:#FFFFFF;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:5px;"><![endif]-->
                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top; width: 650px;">
                    <div style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                            <div style="color:#052d3d;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                <div style="line-height: 14px; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">
                                    <p style="line-height: 24px; text-align: center; font-size: 12px; margin: 0;"><span style="font-size: 20px;">Комментарий к заказу:</span></p>
                                    <p style="line-height: 24px; text-align: center; font-size: 12px; margin: 0;">{{$order->comment}}</p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
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