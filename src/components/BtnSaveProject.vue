<template>
        <button @click="saveProject">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
            </svg>
        </button>
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

                console.log(requestBody);
                
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };

                axios.put('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=save-project', requestBody, config) // DEV
                //axios.post('https://api-events-on-time.thomastestaud.com/index.php?route=event', requestBody, config) //PROD
                    
                .then(response => {
                    
                    console.log(response.data);
                   
                })
                    
                .catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>


<style scoped>

    svg {
        height: 1.8rem;
    }

    
</style>