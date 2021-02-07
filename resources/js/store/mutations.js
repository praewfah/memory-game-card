let mutations = {
    FETCH_CARDS(state, data) {
        state.cards = data.cards;
        state.turns = data.turns;
        state.showSplash = false;

        return state = data
    },

    FLIP_CARDS(state, data) {
        var card_id = data.card.card_id;
        var card_status = data.card.status;

        if (card_status == 'found') {
            for (const [key, value] of Object.entries(state.cards)) {
                if (value.status == 'flipped')
                    state.cards[key].status = 'found';
            }
        } else if (card_status == null || !card_status || card_status == '') {
            data.card.status = 'flipped';
            for (const [key, value] of Object.entries(state.cards)) {
                if (value.status == 'flipped') {
                    setTimeout(function(){ 
                        data.card.status = null;
                        state.cards[key].status = null;
                    }, 1000);
                }
            }
        }

        state.turns.click = data.current_turn;
        state.cards[card_id] = data.card;
    
        if (data.is_complete) {
            state.showSplash = true;
        }

        return state;
    },
}
export default mutations