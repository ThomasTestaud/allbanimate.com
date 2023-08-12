<template>
    
    <router-view></router-view>
    <div class="phone">
      <img src="@/assets/allba.png" alt="Allbanimate logo">
      <h2>Sorry,</h2>
      <p>Allbanimate isn't supported on small screens yet...</p>
    </div>

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
  --main-background: grey;
}

body {
  background-color: grey;
  margin: 0px;
}

.dropdown-menu {
  background-color: rgb(191, 191, 191) !important;
}

.custom-bg {
  background-color: var(--main-background);
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
  background-color: var(--main-background);
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

.phone {
  padding-top: 100px;
  text-align: center;
  position: fixed;
  top: 0px;
  left: 0px;
  height: 100vh;
  width: 100vw;
  background-color: var(--main-background);
  display: none;
}

.phone img {
  height: 100px;
}


@media (max-width: 801px) {
  
  .phone {
    display: inline;
  }
  
}

</style>
