let actions = {
    fetchCards({commit}) {
        axios.get('/api/reset')
        .then(res => {
            commit('FETCH_CARDS', res.data)
        }).catch(err => {
            console.log(err)
        })
    },
    flipCard({commit}, card) {
        if (card.status == 'flipped' || card.status == 'found') 
            return;
        
        axios.post('/api/flip', card)
        .then(res => {
            commit('FLIP_CARDS', res.data)
        }).catch(err => {
            console.log(err)
        });
    },
}
export default actions