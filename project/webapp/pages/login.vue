<template>
  <div>
   <Login />
  </div>
</template>



<script>

export default {
  name: 'HomePage',
  mounted: function() {
    // if(this.$auth.loggedIn == true)  this.$router.push('/');
  },
  methods: {
  }

}

///this.$cookies.get('cookie-name', { parseJSON: false });

</script>
