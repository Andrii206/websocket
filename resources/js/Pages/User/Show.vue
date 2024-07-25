<template>
    <div class="p-6 w-1/2 mx-auto">
        <div class="m-4">
            <h1>Show {{ user.name }}</h1>
        </div>
        <div class="m-4">
            <a @click.prevent="sendLike" href="#" class="rounded-lg block w-48 py-2 bg-sky-400 text-white text-center">Send like</a>
        </div>
        <div class="m-4">
            {{ like_str }}
        </div>
    </div>
</template>
<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
    name: "Show",

    props: [
        'user'
    ],
    data() {
        return {
            like_str: ''
        }
    },

    created()  {
        window.Echo.private(`send_like_${ this.$page.props.auth.user.id}`)
        .listen('.send_like', res => {
            console.log('lox')
            this.like_str = res.like_str
        })
    },

    methods: {
        sendLike() {
            axios.post(`/users/${this.user.id}`, {from_id: this.$page.props.auth.user.id})
            .then( res => {
                
                this.like_str = res.data.like_str
            })
        }
    }
}

</script>
<style scoped>

</style>