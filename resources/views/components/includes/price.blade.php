<section class="pricing">
    <div class="container">
        <div class="row pb-70">
            <div class="col-lg-5 col-12 header-wrap copywriting">
                <p class="story">
                    GOOD INVESTMENT
                </p>
                <h2 class="primary-header text-white">
                    Start Your Journey
                </h2>
                <p class="support">
                    Learn how to speaking in public to demonstrate your <br> final project and receive the important
                    feedbacks
                </p>
                <p class="mt-5">
                    <a href="#" class="btn btn-master btn-thirdty me-3">
                        View Syllabus
                    </a>
                </p>
            </div>
            <div class="col-lg-7 col-12">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="table-pricing paket-gila">
                            <p class="story text-center">
                                {{ $camps[0]->title }}
                            </p>
                            <h1 class="price text-center">
                                {{ $camps[0]->price }}
                            </h1>
                            @foreach ($camps[0]->benefits as $benefit)
                            <div class="item-benefit-pricing mb-4">
                                <img src="{{ asset('assets/images/ic_check.svg') }}" alt="">
                                <p>
                                    {{ $benefit->name }}
                                </p>
                                <div class="clear"></div>
                                <div class="divider"></div>
                            </div>
                            @endforeach
                            <p>
                                <a href="{{ route('checkout.index', $camps[0]) }}"
                                    class="btn btn-master btn-primary w-100 mt-3">
                                    Take This Plan
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="table-pricing paket-biasa">
                            <p class="story text-center">
                                {{ $camps[1]->title }}
                            </p>
                            <h1 class="price text-center">
                                {{ $camps[1]->price }}
                            </h1>
                            @foreach ($camps[1]->benefits as $benefit)
                            <div class="item-benefit-pricing mb-4">
                                <img src="{{ asset('assets/images/ic_check.svg') }}" alt="">
                                <p>
                                    {{ $benefit->name }}
                                </p>
                                <div class="clear"></div>
                                <div class="divider"></div>
                            </div>
                            @endforeach
                            <p>
                                <a href="{{ route('checkout.index', $camps[1]) }}"
                                    class="btn btn-master btn-secondary w-100 mt-3">
                                    Start With This Plan
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-70">
            <div class="col-lg-12 col-12 text-center">
                <img src="{{ asset('assets/images/brands.png') }}" height="30" alt="">
            </div>
        </div>
    </div>
</section>
