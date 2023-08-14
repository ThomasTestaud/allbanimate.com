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
  --main-background: #575757;
  --element-background-color: #828282;
  --element2-background-color: #676767;
  --border-color: rgb(37, 37, 37);
  --button-color: #d8d8d8;
  --selected-background: #b9a58f;
  --selected-border: #dd7610;
}

body {
  background-color: var(--main-background);
  margin: 0px;
  color: white;
}

#app {
  font-family: sans-serif;
}

button {
  cursor: pointer;
  transition: background-color 0.1s;
}

button:active {
  background-color: var(--selected-border)!important;
}

.parameter-bar {
  background-color: var(--element-background-color);
  display: flex;
  margin-bottom: 8px;
  color: white;
  font-size: 15px;
  padding: 3px;
  border-bottom: 2px solid var(--border-color);
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
