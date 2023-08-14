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
/*
:root {
  --element-background-color: rgb(186, 186, 186);
  --element2-background-color: rgb(152, 152, 152);
  --button-color: rgba(255, 255, 255, 0.591);
  --selected-background: rgb(133, 133, 214);
  --selected-border: rgb(51, 51, 192);
  --main-background: grey;
}*/

:root {
  --element-background-color: #c6ac8f;
  --element2-background-color: #eae0d5;
  --button-color: #fdffb6;
  --selected-background: #fee440;
  --selected-border: #ff7d00;
  --main-background: #5e503f;
  --border-color: grey;
}

body {
  background-color: var(--main-background);
  margin: 0px;
}

#app {
  font-family: sans-serif;
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


@media (max-width: 800px) {
  
  .phone {
    display: inline;
  }
  
}

</style>
