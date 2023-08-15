<template>
        <div @click="dowloadAs('mp4')">
            Download Project as MP4
        </div>
        <div @click="dowloadAs('gif')">
            Download Project as GIF
        </div>
</template>

<script>
    import axios from 'axios';

    export default {

        name: 'BtnDownload',
        props: {
            projectData: Object,
        },
        data() {
            return {
                //projectData: this.,
            }
        },
  
        methods: {

            dowloadAs(format) {
                const projectName = this.$route.params.name;

                const requestBody = {
                    targetFormat: format,
                    projectName: projectName,
                    projectData: this.projectData
                };
                
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };

                axios.post(process.env.VUE_APP_API_URL + 'index.php?route=download-project', requestBody, config)
                    
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

    div {
       cursor: pointer;
    }

    
</style>