<template>
  
    <nav>
      <router-link to="/my-projects">My projects</router-link>
      <router-link to="/new-project">New project</router-link>
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
