<template>
  <div class="login">
    <h1>Kasutajad</h1>
    <div class="gym-list">
      <button v-for="gym in gyms" v-on:click="onGymSelect(gym.id)" v-bind:key="gym.id" v-bind:class="{ active: gym.id === activeGym }">{{ gym.name }}</button>
    </div>
    <div class="user-list" v-if="activeGym">
      <p class="total">kokku saalis: <strong>{{ users.length }}</strong></p>
      <div v-for="user in users" v-bind:key="user.id" class="user-card">
        <img v-if="user.photoUrl != null" v-bind:src="user.photoUrl" /><div>{{ user.firstName }} {{ user.lastName }}</div>
      </div>
    </div>
  </div>
</template>

<script>
const API = 'http://localhost:8083/api.php';

export default {
  name: 'gyms',
  data: function() {
    return {
      users: [],
      gyms: [],
      activeGym: null
    }
  },
  methods: {
    async fetchGyms() {
      try {
        const response = await fetch(API + '?type=gyms'+ '&token=' + localStorage.getItem('tok'), {
          method: 'get'
        });
        const json = await response.json();
        this.gyms = json.elements.filter(e => !e.isHidden);
      } catch(err) {
        console.log(err);
      }
    },
    async fetchUsers() {
      try {
        const response = await fetch(API + '?type=users&clubId=' + this.activeGym + '&token=' + localStorage.getItem('tok'), {
          method: 'get',
          headers: {
            'Accept': 'application/json'
          }
        });
        const json = await response.json();
        this.users = json.elements;
      } catch(err) {
        console.log(err);
      }
    },
    onGymSelect(id) {
      this.activeGym = id;
      this.fetchUsers();
    }
  },
  mounted: function() {
    this.fetchGyms();
    if (this.activeGym) {
      this.fetchUsers();
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
button {
  padding: 12px 24px;
  background-color: #efefef;
  margin: 2px;
}
button.active {
  background-color: #42b983;
}
p {
  margin: 0;
}
.total {
  font-size: 20px;
  margin-bottom: 12px;
  margin-top: 12px;
}
.user-list {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.user-card {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  max-width: 200px;
  height: 48px;
  width: 100%;
  position: relative;
  border: 1px solid #efefef;
  padding: 0 6px;
}
.user-card img {
  max-width: 48px;
  margin-right: 12px;
  position: absolute;
  left: 0;
}
</style>
