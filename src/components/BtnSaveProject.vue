<template>
        <div @click="saveProject">
            Save project
        </div>

        <div v-if="saveState == 1" class="notif">
            <div class="loader"></div>
            <p>We are saving you project...</p>
        </div>
        <div v-if="saveState == 2" class="notif">
            <p>Your project has been saved!</p>
        </div>
        <div v-if="saveState == 3" class="notif">
            <p>There has been an error...</p>
        </div>
</template>

<script>
    import axios from 'axios';

    export default {

        name: 'BtnSaveProject',
        props: {
            projectData: Object,
        },
        data() {
            return {
                saveState: 0,
            }
        },
  
        methods: {

            saveProject() {
                this.saveState = 1;

                const projectName = this.$route.params.name;

                const requestBody = {
                    projectName: projectName,
                    projectData: this.projectData
                };
                
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };

                axios.put(process.env.VUE_APP_API_URL + 'index.php?route=save-project', requestBody, config) //PROD
                    
                .then(response => {
                    console.log(response.data);
                    
                    this.saveState = 2;

                    setTimeout(() => {
                        this.saveState = 0;
                    }, 3000);
                })
                    
                .catch(error => {
                    console.log(error);
                    
                    this.saveState = 3;

                    setTimeout(() => {
                        this.saveState = 0;
                    }, 3000);
                });
            },

        }
    }
</script>

<style scoped>

    div {
       cursor: pointer;
    }


    .notif {
        position: fixed;
        bottom: 50px;
        left: 20px;
        border: 2px solid var(--border-color);
        background-color: var(--element-background-color);
        border-radius: 10px;
        padding: 10px;
        display: flex;
        align-items: center;
        animation: appear 0.5s;
        z-index: 4;
    }
    .loader {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0);
        border-top: 5px solid rgba(255, 255, 255, 0.663);
        border-bottom: 5px solid rgba(255, 255, 255, 0.663);
        animation: turn 1s linear infinite;
        margin-right: 15px;
    }

    .away {
        animation: away 0.5s 2.5s;
    }

    @keyframes turn {
        from {
            transform: rotate(0turn);
        }
        to {
            transform: rotate(1turn);
        }
    }

    @keyframes appear {
        from {
            opacity: 0;
            transform: translate(0px, 100px);
        }

        to {
            opacity: 1;
            transform: translate(0px, 0px);
        }
    }

</style>