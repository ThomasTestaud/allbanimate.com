<template>
    
    <router-view></router-view>

</template>

<script>


export default {
  name: 'App',
  
}
</script>

<style>

:root {
  --primary-color: #3498db;
  --element-background-color: rgb(186, 186, 186);
  --selected-background: rgb(133, 133, 214);
}

body {
  background-color: grey;
  margin: 0px;
}

.dropdown-menu {
  background-color: rgb(191, 191, 191) !important;
}

.custom-bg {
  background-color: grey;
}

.dropdown-item {
  cursor: pointer;
}


#app {
  font-family: sans-serif;
}

.pop-up {
  position: fixed;
  left: 50%;
  top: 40%;
  transform: translate(-50%, -50%);
  background-color: grey;
  border: 2px solid black;
  border-radius: 10px;
  padding: 20px;
  min-width: 50%;
  text-align: center;
}

button {
  cursor: pointer;
}

.parameter-bar {
  background-color: rgb(96, 96, 96);
  display: flex;
  margin-bottom: 3px;
  color: white;
  font-size: 15px;
  padding: 2px;
  border-bottom: 1px solid rgb(55, 55, 55);
}
.parameter-bar > * + * {
  margin-left: 10px;
}

.parameter-bar > *:hover {
  color: rgb(147, 147, 205);
}
.parameter-bar a {
  text-decoration: none;
  color: inherit;
}
.parameter-bar button {
  background-color: inherit;
  border: 0px solid black;
  color: inherit;
}
</style>
