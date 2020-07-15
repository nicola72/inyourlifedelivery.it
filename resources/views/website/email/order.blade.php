<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Ordinazione {{$shop->insegna}}</title>
    <style>

        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 12px;
        }

        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.1;
        }

        /* Let's make sure all tables have defaults */
        table td {
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */
        body {
            background-color: #f6f6f6;
            color:#2b2b2b;
        }

        .body-wrap {
            background-color: #f6f6f6;
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            /* makes it centered */
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1, h2, h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            color: #252525;
            margin: 10px 0 0;
            line-height: 1.2;
            font-weight: bold;
        }

        h1 {
            font-size: 32px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 14px;
        }

        h4 {
            font-size: 12px;
            font-weight: bold;
        }

        p, ul, ol {
            margin-bottom: 10px;
            font-weight: normal;
        }
        p li, ul li, ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* -------------------------------------
            LINKS & BUTTONS
        ------------------------------------- */
        a {
            color: #1ab394;
            text-decoration: underline;
        }

    </style>
</head>

<body>
<table width="100%" style="max-width:600px;margin-left:auto;margin-right:auto;border:1px solid #ddd;margin-top:20px;padding:20px;margin-bottom:20px" cellpadding="2" cellspacing="2">
    <tr>
        <th>
            <h3>Ordinazione {{$shop->insegna}} n° {{$order->id}} del {{$order->created_at->format('d/m/Y')}}</h3>
        </th>
    </tr>
    <tr>
        <th>
            <h3 style="margin-bottom:20px;border-bottom:1px solid #ddd;padding-bottom:20px;">
                {{ ($order->tipo == 'domicilio') ? 'CONSEGNA A DOMICILIO' : 'ASPORTO' }}
                <br>
                <small>per le ore: {{substr($order->orario, 0, -3)}}</small>
            </h3>
        </th>
    </tr>
    @if($order->tipo == 'domicilio')
        <tr>
            <td>
                <table width="100%" cellpadding="2" cellspacing="2">
                    <tr>
                        <td>
                            <h3>INDIRIZZO CONSEGNA:</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2">
                                <tr>
                                    <td>
                                        {{$order->orderShipping->indirizzo}}, {{$order->orderShipping->nr_civico}}
                                        <br>{{$order->orderShipping->comune}}
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="0">
                @foreach($order->orderDetails as $item)
                    <tr>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            <h4 style="margin-bottom: 0px">{{$item->nome_prodotto}}</h4>
                            @if($item->variante != '')
                                {{$item->variante}}
                            @endif
                            @if($item->ingredienti_eliminati != '')
                                Senza {{$item->ingredienti_eliminati}}
                            @endif
                            @if($item->ingredienti_aggiunti != '')
                                Con {{$item->ingredienti_aggiunti}}
                            @endif
                        </td>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            {{$item->qta}} x @money($item->prezzo)
                        </td>
                        <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            <h4>Tot. @money($item->totale)</h4>
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" style="border-bottom:1px solid #ddd;margin-bottom:20px" cellpadding="2" cellspacing="2">
                <tr>
                    <td style="text-align: right">
                        @if($order->spese_spedizione != '')
                            <h4>Spese consegna: @money($order->spese_spedizione)</h4>
                        @endif
                        <h3>Totale: @money($order->importo)</h3>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td>
                        <h4>DETTAGLI CLIENTE:</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="2" cellspacing="2">
                            <tr>
                                <td>{{$order->nome}} {{$order->cognome}}<br>tel.:{{$order->telefono}}<br>email: {{$order->email}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td>
                        <h4>METODO PAGAMENTO:</h4>
                        {{$order->modalita_pagamento}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if($order->note != '')
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td>
                        <h4>NOTE:</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="2" cellspacing="2">
                            <tr>
                                <td>{{$order->note}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif
</table>



</body>
</html>
