<template>
    <footer id="footer" class="footer position-relative dark-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <Link :href="route('home')" class="logo d-flex align-items-center">
                            <span class="sitename">Elite Booking</span>
                        </Link>
                        <div class="footer-contact pt-3">
                            <p>27 Avenue des Champs-Élysées</p>
                            <p>75008 Paris, France</p>
                            <p class="mt-3"><strong>{{ $t('front.footer.phone') }} :</strong> <span>+33 1 42 68 53 00</span></p>
                            <p><strong>Email :</strong> <span>contact@elitebooking.com</span></p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>{{ $t('front.footer.useful_links') }}</h4>
                        <ul>
                            <li><Link :href="route('home')">{{ $t('front.header.home') }}</Link></li>
                            <li><Link :href="route('about')">{{ $t('front.footer.about_us') }}</Link></li>
                            <li><Link :href="route('amenities')">{{ $t('front.footer.services') }}</Link></li>
                            <li><a href="#">{{ $t('front.footer.terms_of_service') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.privacy_policy') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>{{ $t('front.footer.our_services') }}</h4>
                        <ul>
                            <li><a href="#">{{ $t('front.footer.room_booking') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.event_hosting') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.spa_wellness') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.fine_dining') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.concierge') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>{{ $t('front.footer.guest_info') }}</h4>
                        <ul>
                            <li><a href="#">{{ $t('front.footer.faq') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.cancellation_policy') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.check_in_out') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.accessibility') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.contact_us') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>{{ $t('front.footer.discover') }}</h4>
                        <ul>
                            <li><Link :href="route('roomTypes.index')">{{ $t('front.header.rooms') }}</Link></li>
                            <li><Link :href="route('amenities')">{{ $t('front.header.amenities') }}</Link></li>
                            <li><a href="#">{{ $t('front.footer.gallery') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.loyalty_program') }}</a></li>
                            <li><a href="#">{{ $t('front.footer.gift_cards') }}</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="copyright text-center">
            <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div>
                        © Copyright <strong><span>Elite Booking</span></strong>. {{ $t('front.footer.all_rights_reserved') }}
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                        {{ $t('front.footer.designed_by') }} <a class="text-white" href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>

            </div>
        </div>

    </footer>
</template>

<script setup>

</script>
