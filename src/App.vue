<template>
    
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
  margin: 0px;
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
</style>
