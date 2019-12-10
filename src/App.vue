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
      loggedIn: !!localStorage.getItem('tok')
    }
  },
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
