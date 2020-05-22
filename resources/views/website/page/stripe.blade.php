@extends('layouts.website')
@section('content')
    <div class="container" style="padding-top:160px;padding-bottom:60px">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="row" >
                    <h3 class="text-center" >Paga con STRIPE</h3>
                    <div class="col-12 col-md-6 offset-md-3" >
                        <img class="img-responsive" src="http://i76.imgup.net/accepted_c22e0.png">
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"  data-cc-on-file="false" data-stripe-publishable-key="{{ $public_key }}" id="payment-form">
                    @csrf
                    <div class="row mb-3">
                        <div class='col-12 required'>
                            <label class='control-label'>Nome sulla carta</label>
                            <input class='form-control' size='4' type='text'>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class='col-12  required'>
                            <label class='control-label'>N° Carta</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-12 col-md-4 mb-3 cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                        </div>

                        <div class='col-12 col-md-4 mb-3 expiration required'>
                            <label class='control-label'>Expiration Month</label>
                            <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                        </div>

                        <div class='col-12 col-md-4 mb-3 expiration required'>
                            <label class='control-label'>Expiration Year</label>
                            <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class='col-md-12 error' style="display: none">
                            <div class='alert-danger alert'>Correggi gli errori e prova di nuovo.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">
                                Paga (@money($order->importo))
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js_script')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        $(function() {

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {

                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]','input[type=text]', 'input[type=file]','textarea'].join(', '),
                    $inputs       = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid         = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');

                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()

                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {

                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.append("<input type='hidden' name='order_id' value='{{encrypt($order->id)}}'/>");
                    $form.get(0).submit();
                }
            }
        });

    </script>
@stop