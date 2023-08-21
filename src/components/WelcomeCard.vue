<template>
    <div class="welcome-card">
        <h1>Welcome to Allbanimate.com !</h1>
        <p>Allbanimate is a free 2D animation software in the early phase of it's developement.</p>
        <p>You can draw and create your own animation films easilly from your browser, without the need to install anything on your computer. You can also convert and download your films as GIFs or MP4 files.</p>
        <img src="@/assets/preview.png" alt="preview">
        <p>Please consider joining the <a target=”_blank” href="https://discord.gg/SADC3rMeYb">official discord server</a> if you want to give feedbacks and report bugs to help the project.</p>
        <p>Current version: Alpha (note that while Allbanimate hasn't reached the Beta version of it's developement, your currents project save files might not be compatible with future updates of the software. To avoid losing your project entirelly, consider downloading your projects as .MP4s or .GIFs from time to time)</p>

    </div>

</template>

<script>
    export default {

        name: 'WelcomeCard',
  
        methods: {

        }
    }
</script>


<style scoped>
    .welcome-card {
        color: white;
    }

    img {
        /*height: 50vh;*/
        max-width: 50vw;
        max-height: 50vh;
    }
    
</style>