<template>
    <section id="booking" class="booking h-fullscreen">
        <div class="d-flex justify-content-center mt-6 h-full">
            <div class="booking-form-section" style="width: 600px">
                <div class="form-container w-full">
                    <form class="reservation-form" @submit.prevent="submitLogin" method="POST">
                        <div class="form-section mb-3">
                            <h4>{{ $t('front.auth.complete_register.title') }}</h4>
                            <div class="form-grid">
                                <div class="form-group full-width mb-0">
                                    <label for="first_name" class="form-label required">{{ $t('front.auth.complete_register.first_name') }}</label>
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="form.first_name"
                                           :class="{'is-invalid': form.errors.first_name}"
                                           placeholder="first name" required="">
                                    <div class="invalid-feedback" v-show="form.errors.first_name"
                                         v-text="form.errors.first_name"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="last_name" class="form-label required">{{ $t('front.auth.complete_register.last_name') }}</label>
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="form.last_name"
                                           :class="{'is-invalid': form.errors.last_name}"
                                           placeholder="last name" required="">
                                    <div class="invalid-feedback" v-show="form.errors.last_name"
                                         v-text="form.errors.last_name"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="mobile" class="form-label">{{ $t('front.auth.complete_register.mobile') }}</label>
                                    <input type="text" class="form-control" id="mobile"
                                           v-model="form.mobile"
                                           :class="{'is-invalid': form.errors.mobile}"
                                           placeholder="mobile">
                                    <div class="invalid-feedback" v-show="form.errors.mobile"
                                         v-text="form.errors.mobile"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="password" class="form-label required">{{ $t('front.auth.complete_register.password') }}</label>
                                    <input type="password" class="form-control" id="password"
                                           v-model="form.password"
                                           :class="{'is-invalid': form.errors.password}"
                                           placeholder="1234" required="">
                                    <div class="invalid-feedback" v-show="form.errors.password"
                                         v-text="form.errors.password"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="password_confirm" class="form-label required">{{ $t('front.auth.complete_register.password_confirm') }}</label>
                                    <input type="password" class="form-control" id="password_confirm"
                                           v-model="form.password_confirmation"
                                           :class="{'is-invalid': form.errors.password_confirmation}"
                                           placeholder="1234" required="">
                                    <div class="invalid-feedback" v-show="form.errors.password_confirmation"
                                         v-text="form.errors.password_confirmation"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-door-open me-2" style="font-size: 18px"></i>
                                {{ $t('front.auth.complete_register.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    first_name: '',
    last_name: '',
    mobile: '',
    password: '',
    password_confirmation: '',
})

const submitLogin = () => {
    form.post(route('completeRegister'));
}
</script>

