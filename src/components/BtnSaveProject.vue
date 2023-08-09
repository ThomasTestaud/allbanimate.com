<template>
        <div @click="saveProject">
            Save project
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
                //projectData: this.,
            }
        },
  
        methods: {

            saveProject() {
                const projectName = this.$route.params.name; // Get the graph ID from the route

                const requestBody = {
                    projectName: projectName,
                    projectData: this.projectData
                };

                //console.log(requestBody);
                
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };

                //axios.put('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=save-project', requestBody, config) // DEV
                axios.put('https://allbanimate.thomastestaud.com/backend/index.php?route=save-project', requestBody, config) //PROD
                    
                .then(response => {
                    
                    console.log(response.data);
                    this.$emit('save', true);
                   
                })
                    
                .catch(error => {
                    console.log(error);
                    this.$emit('save', false);
                });
            },

        }
    }
</script>


<style scoped>

    div {
       cursor: pointer;
    }

    
</style>