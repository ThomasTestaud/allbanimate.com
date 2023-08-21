<template>
        <div @click="deconnect"  class="btn-deconnexion">
            Deconnexion
        </div>
</template>

<script>
    export default {

        name: 'BtnDeconnexion',
  
        methods: {

            deconnect() {
            localStorage.setItem("token", null);
            this.$router.push({ path: `/connect/` });
          },
        }
    }
</script>


<style scoped>

    svg {
        height: 1.8rem;
        margin-right: 3px;
    }

    button {
        display: flex; 
        align-items: center;
        justify-content: center;
    }
    
</style>