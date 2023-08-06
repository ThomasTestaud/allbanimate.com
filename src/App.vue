<template>
  
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/projects">Projects</router-link>
      <router-link to="/connexion">Connexion</router-link>
    </nav>
    <router-view></router-view>
</template>

<script>


export default {
  name: 'App',
  
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
