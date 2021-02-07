<template>
    <div class="cards">
        <div v-for="card in cards" class="card" :class="card.status" @click="flipCard(card)">
            <div class="back"></div>
            <div class="front">{{ card.card_value }}</div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Cards",
        mounted() {
            this.$store.dispatch('fetchCards')
        },
        methods: {
            flipCard(card) {
                this.$store.dispatch('flipCard', card);
            }
        },
        computed: {
            ...mapGetters([
                'cards'
            ])
        }
    }
</script>
