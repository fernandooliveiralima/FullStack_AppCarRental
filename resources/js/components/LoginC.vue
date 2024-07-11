<script setup>
/* Vue Imports */
import { defineProps, ref } from 'vue';


/* Vue Props */
const props = defineProps({
    token_csrf: { type: String, required: true }
});

/* Vue Methods */
/* Variables */
const userEmail = ref('');
const userPassword = ref('');

/* App Methods */
const login = async (event) => {
    try 
    {
        let url = 'http://localhost:8000/api/login';

        let userConfig = {
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': props.token_csrf
            },
            body: JSON.stringify({
                'email': userEmail.value,
                'password': userPassword.value
            })
        };

        await fetch(url, userConfig)
            .then((response) => response.json() )
            .then((data) => {
                if(data.access_token){
                    document.cookie = `token=${data.access_token}`;
                };
            })

        event.target.submit();
        
    } catch (error) {
        console.log('Error:', error);
    }
};
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">LoginC</div>

                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">
                            <input type="hidden" name="_token" :value="props.token_csrf" />
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required
                                        autocomplete="email" autofocus v-model="userEmail" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="current-password" v-model="userPassword" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            KeepMe Connected
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                    <a class="btn btn-link" href="">Forgot The Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
