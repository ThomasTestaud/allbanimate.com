<template>
  <h2>PLAYER IMG</h2>
  <img :src="img" alt="video here">
</template>
  
  <script>
  
  export default {
    name: 'PlayerImg',
    props: {
      img: String,
    },
  
  }
  </script>

  <style scoped>

  img {
    height: 100px;
  }
  </style>