<template>
    <div class="row score">
        <div class="col-3 col-md-12">
            Click : <div class="title" v-text="turns.click" ></div>
        </div>
        <div class="col-3 col-md-12">
            My Best : <div class="title" v-text="turns.my_best_turn"></div>
        </div>
        <div class="col-3 col-md-12">
            Global Best : <div class="title" v-text="turns.global_best_turn"></div>
        </div>

        <div class="col-3 col-md-12">
            <button @click="resetGame()">New Game</button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Score",
        mounted() {
            
        },
        methods: {
            resetGame() {
                this.$store.dispatch('fetchCards');
            }
        },
        computed: {
            ...mapGetters([
                'turns'
            ])
        }
    }
</script>
