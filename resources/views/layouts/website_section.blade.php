<section class="lightSection clearfix"	style="height: auto; padding-top: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4"
                 style="font-size: 130%; line-height: 1.6em; margin-bottom: 30px;">
                <img src="/img/care.png" alt="" class="img-responsive" style="height: 70px; float: left; margin-right: 20px;" />
                <strong>Customer Care</strong><br /> @lang('msg.per_consegne_urgenti'):<br />
                <i class="fa fa-phone"></i> +39 328 0090798<br />

            </div>
            <div class="col-md-4" style="margin-bottom: 30px;">
                <div class="newsletter clearfix">
                    <h4>@lang('msg.iscriviti_alla_newsletter')</h4>
                    <form id="newsletter_form" method="get" action="" onsubmit="addToNewsletter('{{app()->getLocale()}}')">
                        <div class="input-group">

                            <input name="news_email" id="news_email" type="text" class="form-control"	placeholder="inserisci la tua email" aria-describedby="basic-addon2">
                            <a href="javascript:void(0)" class="input-group-addon" id="basic-addon2" onclick="addToNewsletter('{{app()->getLocale()}}')">
                                @lang('msg.invia') <i class="fa fa-arrow-circle-right"></i>
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>