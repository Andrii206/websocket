<template>
    <div class="w-1/2 mx-auto py-6">
        <div v-if="messages && messages.length > 0">
            <h3 class="m-10">Masseges</h3>
            <div v-for="message in messages"
                class="text-sm pb-2 mb-4 border-b border-gray-300 rounded-lg w-1/2 bg-sky-200 p-5">
                <p>{{ message.id }}</p>
                <p class="ms-10">{{ message.body }}</p>
                <p class="text-right">{{ message.time }}</p>
            </div>
        </div>
        <div>
            <div class="mt-12">
                <input type="text" class="rounded-full border border-gray-400" placeholder="Your message"
                    v-model="body">
            </div>
            <div class="mt-3">
                <a @click.prevent="store" href="#"
                    class="rounded-lg block w-48 py-2 bg-sky-400 text-white text-center">Sent</a>
            </div>
        </div>
    </div>
</template>
<style scoped></style>
<script>

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


export default {
    name: "Index",
    props: [
        'messages'
    ],
    data() {
        return {
            body: ''
        }
    },
    created() {
        window.Echo.channel('store_message')
            .listen('.store_message', res => {
                this.messages.unshift(res.message);
            });
    },
    methods: {
        store() {
            axios.post('/message', { body: this.body })
                .then(res => {
                    this.messages.unshift(res.data);
                });
        }
    }
};

</script>