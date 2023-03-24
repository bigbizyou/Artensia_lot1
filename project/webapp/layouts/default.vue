<template>
  <div  v-if="this.$auth.loggedIn==true" >
      <section>
        <nav
          class="navbar header has-shadow is-primary"
          role="navigation"
          aria-label="main navigation"
        >
          <div class="navbar-brand">
            <a
              class="navbar-item"
              href="/"
            >
              <img
                src="~assets/artensia_logo.png"
                alt="Artensia"
                height="28"
              >&nbsp;Artensia
            </a>



            <div class="navbar-burger">
              <span />
              <span />
              <span />
            </div>
          </div>
          <div class="navbar-menu">
            <div class="navbar-start">

            </div>
            <div class="navbar-end">
              <b-navbar-dropdown right :label="usermail">
                <b-navbar-item v-on:click="userLogout()" >
                    Déconnexion
                </b-navbar-item>
              </b-navbar-dropdown>
              <!--
                <div class="navbar-item">
                  <div class="buttons">
                    <a class="button is-prima" v-on:click="userLogout()"  >Deconnexion</a>
                  </div>
                </div>
              -->
            </div>
          </div>
        </nav>

      </section>
      <div class="container  is-max-desktop">
        <RequestPdf />
      </div>
  </div>
  <div class="container  is-max-desktop" v-else="this.$auth.loggedIn==false" >
    <Login />
  </div>
</template>

<script>
  export default {
    name: 'NavBar',
    data() {
      return {
        usermail: ""
      }
    },
    mounted: function() {
      this.usermail = this.$store.state.auth.user.email
    },
    methods: {
      userLogout: function() {
        this.$auth.logout();
      },
    }

  }
</script>
