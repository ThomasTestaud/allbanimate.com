<template>
  <HelloWorld/>
  <!--<nav>
      <router-link to="/">Home</router-link>
      <router-link to="/gallerie">Gallerie</router-link>
      <router-link to="/about">About</router-link>
    </nav>
    <router-view></router-view>-->
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  components: {
    HelloWorld
  }
}
</script>

<style>

body {
  background-color: grey;
}

#app {
  font-family: sans-serif;
}

</style>
