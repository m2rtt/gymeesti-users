<template>
  <div class="login">
    <h1>Login</h1>
    <div class="login-form">
      <input type="email" placeholder="email" v-model="email" />
      <input type="password" placeholder="password" v-model="password" />
      <button v-on:click="onLogin()">login</button>
    </div>
  </div>
</template>

<script>
const LOGIN_ENDPOINT = 'https://gymestonia.perfectgym.com/Api/oauth/authorize';
export default {
  name: 'login',
  data: function() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async onLogin() {
      try {
        const response = await fetch(LOGIN_ENDPOINT, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'username=' + this.email + '&password=' + this.password + '&grant_type=password'
        });
        const json = await response.json();
        localStorage.setItem('tok', json.access_token);
        localStorage.setItem('exp', json.expires_in);
        this.$emit('onLoggedIn', true);
      } catch(err) {
        console.log(err);
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.login {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.login-form {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  max-width: 300px;
}
input {
  padding: 12px 24px;
  background-color: #efefef;
  margin: 2px;
  font-size: 14px;
  display: block;
  width: 100%;
}
button {
  padding: 12px 24px;
  background-color: #42b983;
  margin: 2px;
  font-size: 16px;
  font-weight: 600;
  width: 100%;
  color: white;
}
</style>
