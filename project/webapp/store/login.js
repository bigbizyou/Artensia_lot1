export const state = () => ({
  user: []
})

export const getter = {
  getUser(state) {
    return state.user
  }
}

export const mutations = {
  setUser(state , user) {
    state.user = user;
  }
}




// export const actions = {
//   async fetchCounter(state) {
//     // make request
//     const res = { data: 10 };
//     state.counter = res.data;
//     return res.data;
//   }
//}
