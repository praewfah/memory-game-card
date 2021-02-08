<template>
    <div class="score">
        <div class="score-item">
            <div class="label">Click :</div>
            <div class="title" v-text="turns.click"></div>
        </div>
        <div class="score-item">
            <div class="label">My Best :</div>
            <div class="title" v-text="turns.my_best_turn"></div>
        </div>
        <div class="score-item">
            <div class="label">Global Best :</div>
            <div class="title" v-text="turns.global_best_turn"></div>
        </div>
        <div class="score-item">
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
