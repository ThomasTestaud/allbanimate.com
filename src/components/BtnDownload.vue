<template>
        <div @click="handleServerTransaction">
            Download Project as MP4
        </div>
        <div @click="dowloadAs('gif')">
            Download Project as GIF
        </div>
        <div v-if="progressWindow" class="progress-window">
            <canvas ref="rendercanvas" id="renderCanvas" width="800" height="500"></canvas>
            <p>Converting your project...</p>
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
                progressWindow: false,
                calkLayers: this.projectData.calkLayers,
            }
        },

        mounted() {
            
        },
  
        methods: {
            handleServerTransaction() {
                this.progressWindow = true;

                this.$nextTick(() => {
                    //console.log(this.calkLayers[0].code);
                    console.log(this.$refs.rendercanvas);
                    
                    
                    this.calkLayers[0].code.forEach((frame, index) => {
                        //console.log(this.renderFrame(index));
                        this.uploadImgs(this.renderFrame(index));
                    });
                });


                

            },

            renderFrame(indexFrame) {
                
                const canvas = this.$refs.rendercanvas;
                
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                // Get the center coordinates of the canvas
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                console.log(centerX + centerY);
                
                this.calkLayers.forEach((layer, indexLayer) => {
                    if(layer.displayed) {
                        eval(this.returnLastDrawnedFrameFrom(indexLayer, indexFrame));
                    }
                });
                
                //console.log(this.canvas.toDataURL('image/png'));
                return canvas.toDataURL('image/png');
                
            },

            uploadImgs(dataURL) {

                const requestBody = {
                    imageData: dataURL
                };
                
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };

                axios.post(process.env.VUE_APP_API_URL + 'index.php?route=upload-project', requestBody, config)
                    
                .then(response => {
                    
                    console.log(response.data);
                   
                })
                    
                .catch(error => {
                    console.log(error);
                });
            },

            dowloadAs(format) {
                const projectName = this.$route.params.name;

                const requestBody = {
                    targetFormat: format,
                    projectName: projectName,
                    projectData: this.projectData,
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

            returnLastDrawnedFrameFrom(layer, frame) {
                if(this.calkLayers[layer].code[frame] !== "") {
                    return this.calkLayers[layer].code[frame];
                }
                if(frame === 0) {
                    return this.calkLayers[layer].code[frame];
                }
                return this.returnLastDrawnedFrameFrom(layer, frame-1);
            },
        }
    }
</script>


<style scoped>

    div {
       cursor: pointer;
    }

    .progress-window {
        border: 1px solid green;
        position: fixed;
        border: 2px solid var(--border-color);
        min-height: 20%;
        min-width: 20%;
        left: 50%;
        top: 40%;
        transform: translate(-50%, -50%);
        text-align: center;
        border-radius: 1rem;
        background-color: var(--main-background);
        padding: 1rem;
        box-sizing: border-box;
    }

    canvas {
        height: 90px;
        width: 140px;
        background-color: black;
    }

    
</style>