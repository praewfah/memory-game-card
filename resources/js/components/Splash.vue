<template>
    <div class="splash" v-if="showSplash">
        <div class="overlay"></div>
        <div class="content">
            <div class="title" v-text="'Total Click: ' + turns.click"></div>
            <button @click="resetGame()">Play again!</button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Splash",
        mounted() {
            
        },
        methods: {
            resetGame() {
                this.$store.dispatch('fetchCards');
            }
        },
        computed: {
            ...mapGetters([
                'turns',
                'showSplash',
            ])
        }
    }
</script>
