<template>
  <div id="app">
    <Login v-if="!loggedIn" @onLoggedIn="loggedIn = true" />
    <Gyms v-if="loggedIn" />
  </div>
</template>

<script>
import Login from './components/Login.vue'
import Gyms from './components/Gyms.vue'

export default {
  name: 'app',
  components: {
    Login,
    Gyms
  },
  data: function() {
    return {
      loggedIn: this.checkLoggedStatus()
    }
  },
  methods: {
    checkLoggedStatus() {
      const token = localStorage.getItem('tok');
      const expTime = localStorage.getItem('exp');
      const authTime = localStorage.getItem('authtime');
      if (!token || !expTime || !authTime) {
        return false;
      }
      const currentTime = new Date().getTime();
      return (currentTime - parseInt(authTime)) < parseInt(expTime);
    }
  }
}
</script>

<style>
body {
  margin: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #46555E;
  margin-top: 32px;
  margin-bottom: 32px;
  padding: 0 12px;
}
</style>
