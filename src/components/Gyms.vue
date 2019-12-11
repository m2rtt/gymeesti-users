<template>
  <div class="login">
    <h1>Saalide info</h1>
    <div class="gym-list">
      <button v-for="gym in gyms" v-on:click="onGymSelect(gym.id)" v-bind:key="gym.id" v-bind:class="{ active: gym.id === activeGym }">{{ gym.name }}</button>
    </div>
    <h3 v-if="!activeGym">Külastajate arvu nägemiseks vali saal</h3>
    <p v-if="activeGym" class="total">Saalis kokku: <strong v-bind:class="{
      'too-much': users.length >= 70,
      'risky': users.length >= 50 && users.length < 70,
      'good': users.length < 50
    }">{{ users.length }}</strong></p>
    <div class="user-list" v-if="activeGym">
      <div v-for="user in users" v-bind:key="user.id" class="user-card">
        <img v-if="user.photoUrl != null" v-bind:src="user.photoUrl" /><div>{{ user.firstName }} {{ user.lastName }}</div>
      </div>
    </div>
  </div>
</template>

<script>
const API = 'https://www.morsakabi.com/gym/api.php';

export default {
  name: 'gyms',
  data: function() {
    return {
      users: [],
      gyms: [],
      activeGym: localStorage.getItem('gym') && parseInt(localStorage.getItem('gym')) || null
    }
  },
  methods: {
    async fetchGyms() {
      try {
        const response = await fetch(API + '?type=gyms'+ '&token=' + localStorage.getItem('tok'));
        const json = await response.json();
        this.gyms = json.elements.filter(e => !e.isHidden);
      } catch(err) {
        console.log(err);
      }
    },
    async fetchUsers() {
      try {
        const response = await fetch(API + '?type=users&clubId=' + this.activeGym + '&token=' + localStorage.getItem('tok'));
        const json = await response.json();
        this.users = json.elements;
      } catch(err) {
        console.log(err);
      }
    },
    onGymSelect(id) {
      this.activeGym = id;
      localStorage.setItem('gym', id);
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
a {
  color: #42b983;
}
.gym-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
button {
  padding: 10px;
  background-color: #efefef;
  margin: 2px;
  width: 100%;
  max-width: 300px;
  min-width: 170px;
  flex: 25%;
  font-size: 12px;
  cursor: pointer;
  border: 1px solid #ececec;
}
button:hover {
  background-color: #42b983;
}
button.active {
  background-color: #42b983;
  border: 1px solid #42b983;
  color: white;
  font-weight: 600;
}
button:focus {
  outline: none;
}
p {
  margin: 0;
}
.total {
  font-size: 20px;
  margin-bottom: 12px;
  margin-top: 12px;
}
.total strong {
  font-size: 24px;
}
.total strong.too-much {
  color: #C00000;
}
.total strong.good {
  color: #00A000;
}
.total strong.risky {
  color: #EE9900
}
.user-list {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
.user-card {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  max-width: 220px;
  height: 48px;
  width: 100%;
  position: relative;
  border: 1px solid #efefef;
  padding: 0 6px;
  margin: 1px 4px;
  flex: 33%;
}
@media (max-width: 567px) {
  .user-list {
    justify-content: center;
  }
  .user-card {
    flex: 100%;
    max-width: 300px;
  }
  button {
    flex: 100%;
    max-width: 300px;
  }
}
.user-card img {
  max-width: 48px;
  margin-right: 12px;
  position: absolute;
  left: 0;
}
.user-card:hover img {
  max-width: 256px;
  z-index: 1;
}
</style>
