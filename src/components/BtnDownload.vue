<template>
        <div @click="handleDropDown" >
            Download
            <div v-if="dropDown" class="drop-down" >
                <div @click="handleServerTransaction('mp4')">
                    Download Project as MP4
                </div>
                <div @click="handleServerTransaction('gif')">
                    Download Project as GIF
                </div>
            </div>
            <div v-if="progressWindow" class="progress-window">
                <canvas ref="rendercanvas" id="renderCanvas" width="800" height="500"></canvas>
                <p v-if="progress !== false">{{ Math.floor(progress) }}%</p>
                <p v-else>Please wait,</p>
                <p>{{ progressMessage }}</p>
            </div>
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
                progress: 0,
                progressMessage: "",
                dropDown: false,
            }
        },
  
        methods: {
            handleDropDown() {
                if(this.dropDown) {
                    this.dropDown = false;
                } else {
                    this.dropDown = true;
                }
            },

            handleServerTransaction(format) {
                this.progressWindow = true;
                this.progress = 0;
                this.progressMessage = "Rendering your project...";

                this.$nextTick(() => { // For letting Vue.js render the pop-up
                    
                    let i = 0;
                    let run = setInterval( ()=> { // For forcing vue.js to render the data on the page in-between each update
                        
                        this.progress+= 100/this.calkLayers[0].code.length;
                        this.uploadImgs(this.renderFrame(i));

                        if (i === this.calkLayers[0].code.length-1) {
                            clearInterval(run);
                            this.dowloadAs(format);
                        }

                        i++;
                    }, 100);

                });
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
                    this.progressMessage = "We're sorry, there has been an error...";
                    setTimeout(() => {
                        this.progressWindow = false;
                    }, 2000);
                });
            },

            dowloadAs(format) {
                this.progress = false;
                this.progressMessage = "We are converting your project to " + format + "...";

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
                    },
                    timeout: 30000,
                };

                axios.post(process.env.VUE_APP_API_URL + 'index.php?route=download-project', requestBody, config)
                    
                .then(response => {
                    console.log(response.data);
                    const gifLink = response.data;
                    // Create an anchor element
                    const downloadLink = document.createElement('a');
                    downloadLink.href = gifLink;
                    downloadLink.target = '_blank'; // Open in a new tab/window
                    // Extract the filename from the link
                    const filename = gifLink.substring(gifLink.lastIndexOf('/') + 1);
                    // Set the download attribute to specify the filename
                    downloadLink.download = filename;
                    // Append the link to the document and click it to trigger the download
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    // Remove the link from the document
                    document.body.removeChild(downloadLink);
                    
                    this.progressWindow = false;
                })
                    
                .catch(error => {
                    console.log(error);
                    this.progressMessage = "We're sorry, there has been an error...";
                    setTimeout(() => {
                        this.progressWindow = false;
                    }, 2000);
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
                return canvas.toDataURL('image/png');
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

    .drop-down {
        position: absolute;
        top: 23px;
        background-color: var(--main-background);
        border: 2px solid var(--border-color);
        border-radius: 3px;
    }

    .drop-down > div {
        padding: 5px;
        color: white;
        transition: background-color 0.1s;
    }

    .drop-down > div:hover {
        background-color: var(--element-background-color);
    }
    
</style>