<template>
  <div class="container  is-max-desktop" >
    <div class="columns is-vcentered is-centered">


      <div class="column is-6 is-vcentered">
        <form class="box" v-if="this.$auth.loggedIn==false" @submit.prevent="userLogin">
          <div>
            <img src="" style="width: 70%; height:auto; display: block; margin:32px auto;" />
          </div>
          <p>
            &nbsp;
          </p>
          <b-field label="Email">
            <b-input value="" v-on:focus="showInError(false)" v-model="login.username" ></b-input>
          </b-field>
          <b-field label="Mot de passe">
            <b-input value="" type="password"  v-on:focus="showInError(false)"  v-model="login.password" ></b-input>
          </b-field>
          <div></div>
          <div class="buttons" v-if="this.requestLogin==false" >
            <b-button type="is-primary" v-on:click="request(true)"  expanded>Connexion</b-button>
          </div>
          <div v-if="this.inError==true" >
            <b-message type="is-danger" >
              Email et/ou mot de passe inccorect(s)
            </b-message>
          </div>
          <progress v-if="this.requestLogin==true" class="progress is-large is-primary" max="100">15%</progress>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
// import Vue from 'vue'
// import Buefy from 'buefy'
// import 'buefy/dist/buefy.css'

export default {
  data() {
    return {
      login: {
        username: '',
        password: ''
      },
      requestLogin: false,
      inError: false
    }
  },
  mounted: function() {
    console.log('mounted');
    // if(this.$auth.loggedIn == true)  this.$router.push('/home');
  },
  methods: {
    async userLogin() {
      try {
        this.requestLogin = true;

        let response = await this.$auth.loginWith('local', { data: this.login })

        console.log(response);

        if(this.$auth.loggedIn == true){
          this.requestLogin = false;
          this.$router.push('/');

           this.$store.commit('login/setUser', this.$auth.user);


        }

      } catch (err) {
        this.showInError(true);
        this.requestLogin = false;
        console.log(err)
      }
    },
    request: function(value) {
      this.userLogin();
      this.requestLogin = value;
    },
    showInError: function(value) {
      this.inError = value;
      if(value == true)
        setTimeout( ()=> { this.inError = false } , 5000);
    }
  }
}


</script>
