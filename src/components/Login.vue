<template>
  <div class="login">
    <h1>Login</h1>
    <div class="login-form">
      <input type="email" placeholder="email" v-model="email" required />
      <input type="password" placeholder="password" v-model="password" required />
      <button v-bind:class="{ disabled: !email || !password }" v-on:click="onLogin()">login</button>
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
        localStorage.setItem('exp', json.expires_in * 1000);
        localStorage.setItem('authtime', new Date().getTime())
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
  padding: 10px 24px;
  background-color: #efefef;
  margin: 2px;
  font-size: 12px;
  display: block;
  width: 100%;
  border: 1px solid #ccc;
}
input:focus {
  outline: none;
  border: 1px solid #42b983;
}
button {
  padding: 10px;
  background-color: #42b983;
  margin: 2px;
  font-size: 12px;
  font-weight: 600;
  width: 100%;
  color: white;
  border: none;
  cursor: pointer;
}
button:focus {
  outline: none;
}
button:hover {
  background-color: #379e70;
}
button.disabled {
  pointer-events: none;
  background-color: #ccc;
}
</style>
