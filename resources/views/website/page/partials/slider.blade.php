<div class="bannercontainer">
    <div class="fullscreenbanner-container">
        <div class="fullscreenbanner">
            <ul>
                @if($slider->images)
                    @foreach($slider->images as $img)
                        <li data-transition="slidehorizontal" data-slotamount="5" data-masterspeed="700" data-title="Slide 1" >
                            <img src="{{ $website_config['slider_dir'].$img->path }}" alt="{{ $seo->alt ?? '' }}" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                            <div class="slider-caption container captionCenter">
                                <div class="tp-caption rs-caption-1 sft start captionCenterAlign"
                                     data-x="center"
                                     data-y="0"
                                     data-speed="800"
                                     data-start="1500"
                                     data-easing="Back.easeInOut"
                                     data-endspeed="300">
                                    <span class="slider-caption hidden-xs">Shop online<br><i class="fa fa-angle-down"></i></span>

                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>