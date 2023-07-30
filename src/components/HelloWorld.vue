<template>
  <div>
    <div id="upper-section">
      
      <div class="tool-section">
        <div id="tool-parameters">
          <div v-if="drawingToolsData.currentTool.size === true">
            <label for="">Size: </label>
            <input type="range" min="1" max="150" v-model="drawingToolsData.currentSize">
          </div>
          <div v-if="drawingToolsData.currentTool.opacity === true">
            <label for="">Opacity: </label>
            <input type="range" min="1" max="100" v-model="drawingToolsData.currentOpacity">
          </div>
          <div v-if="drawingToolsData.currentTool.particleSize === true">
            <label for="">Particle size: </label>
            <input type="range" min="1" max="15"  v-model="drawingToolsData.currentParticleSize">
          </div>
          <div v-if="drawingToolsData.currentTool.density === true">
            <label for="">Density: </label>
            <input type="range" min="1" max="60"  v-model="drawingToolsData.currentDensity">
          </div>
        </div>
        <div class="tool-section-left">
          <button v-if="drawingToolsData.currentTool === toolsMetaData.crayon" class="selected"><img src="@/assets/crayon.png" alt="crayon"></button>
          <button v-else @click="selectTool(toolsMetaData.crayon)"><img src="@/assets/crayon.png" alt="crayon"></button>
          <button v-if="drawingToolsData.currentTool === toolsMetaData.spray" class="selected"><img src="@/assets/spray.png" alt="spray"></button>
          <button v-else @click="selectTool(toolsMetaData.spray)"><img src="@/assets/spray.png" alt="spray"></button>
          <button><img src="@/assets/eraser.png" alt="eraser"></button>
          <button><img src="@/assets/pipette.png" alt="pipette"></button>
          <button><img src="@/assets/dots.png" alt="dots"></button>
          <button><img src="@/assets/dots.png" alt="dots"></button>
          <button><img src="@/assets/dots.png" alt="dots"></button>
          <button><img src="@/assets/dots.png" alt="dots"></button>
          <button><img src="@/assets/dots.png" alt="dots"></button>
          <button><img src="@/assets/clearcanvas.png" alt="clearcanvas"></button>
        </div>
      </div>
      <canvas ref="canvas" id="myCanvas" width="800" height="500"
      @mousedown="handleMouseDown" @mouseup="handleMouseUp" @mousemove="handleMouseMove"></canvas>
      <div class="tool-section tool-section-right">
        <div id="color-tools">
          <canvas ref="colorCanvas" id="color-canvas" width="300" height="100" @click="pickColorFromColorCanvas"></canvas>
        </div>
        <div id="onion-parameters" @mousemove="displayOnionLayers">
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[0]" class="onion-slider">
            <button v-if="onionLayerState[0] !== false" class="selected" @click="selectOnionLayer(0)"><img src="@/assets/onoin-3.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(0)"><img src="@/assets/onoin-3.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[1]" class="onion-slider">
            <button v-if="onionLayerState[1] !== false" class="selected" @click="selectOnionLayer(1)"><img src="@/assets/onoin-2.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(1)"><img src="@/assets/onoin-2.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[2]" class="onion-slider">
            <button v-if="onionLayerState[2] !== false" class="selected" @click="selectOnionLayer(2)"><img src="@/assets/onoin-1.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(2)"><img src="@/assets/onoin-1.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[3]" class="onion-slider">
            <button v-if="onionLayerState[3] !== false" class="selected" @click="selectOnionLayer(3)"><img src="@/assets/onion.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(3)"><img src="@/assets/onion.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[4]" class="onion-slider">
            <button v-if="onionLayerState[4] !== false" class="selected" @click="selectOnionLayer(4)"><img src="@/assets/onoin+1.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(4)"><img src="@/assets/onoin+1.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[5]" class="onion-slider">
            <button v-if="onionLayerState[5] !== false" class="selected" @click="selectOnionLayer(5)"><img src="@/assets/onoin+2.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(5)"><img src="@/assets/onoin+2.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[6]" class="onion-slider">
            <button v-if="onionLayerState[6] !== false" class="selected" @click="selectOnionLayer(6)"><img src="@/assets/onoin+3.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(6)"><img src="@/assets/onoin+3.png" alt="onion"></button>
          </div>
        </div>
      </div>
    </div>
    <div id="video-controls">
      <button @click="previousFrame"><img src="@/assets/leftskip.png" alt="leftskip"></button>
      <button @click="stop"><img src="@/assets/pause.png" alt="pause"></button>
      <button @click="play"><img src="@/assets/play.png" alt="play"></button>
      <button @click="nextFrame"><img src="@/assets/rightskip.png" alt="rightskip"></button>
    </div>
    <div id="frame-parameters">
      <span>
        <label for="frame-rate">Frame rate: </label>
        <input type="number" id="frame-rate" v-model="frameRate" @keyup="updateFrameRate" @click="updateFrameRate">
        /s
      </span>
      <span>
        <button @click="createNewFrame">Create new frame</button>
        <button @click="duplicateSelectedFrame">Duplicate selected frame</button>
        <button @click="deleteSelectedFrame">Delete selected frame</button>
      </span>
    </div>
    <div id="lower-section">
      <!--<div id="timeline">
        <div class="layer">
          <span class="frame" v-for="(frame, index) in frames" :key="frame.code" @click="selectFrame(index)">
            <button v-if="index == displayedFrame" class="selected-frame"></button>
            <button v-else></button>
          </span>
        </div>
      </div>-->

      <div id="timeline">
        <div v-for="(frames, calkIndex) in calkLayers" :key="frames" class="layer" @click="selectedCalk = calkIndex">
          <span class="frame" v-for="(frame, index) in frames" :key="frame.code" @click="selectFrame(index)">
            <button v-if="index == displayedFrame && calkIndex == selectedCalk" class="selected-frame"></button>
            <button v-else-if="index == displayedFrame && calkIndex !== selectedCalk" class="semi-selected-frame"></button>
            <button v-else></button>
          </span>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'HelloWorld',
  components: {
  },
  data() {
    return {
      frames: [
        {code: ""},
        {code: ""},
        {code: ""},
        {code: ""},
        {code: ""},
        {code: ""},
        {code: ""},
      ],
      calkLayers: [
        [
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
        ],
        [
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
          {code: ""},
        ]
      ],
      frameRate: 6,
      drawingToolsData: {
        currentTool: false,
        currentColor: false,
        currentSize: 10,
        currentOpacity: 100,
        currentParticleSize: 3,
        currentDensity: 40,
        currentRGB: [0, 0, 0],
      },
      displayedFrame: 0,
      selectedCalk: 0,
      interval: null,
      canvas: null,
      canvasData: null,
      lineWidth: 10,
      penDown: false,
      videoBeingPlayed: false,
      onionValue: [1, 5, 10, 100, 10, 5, 1],
      onionLayerState: [true, true, true, true, false, false, false],
      toolsMetaData: {
        crayon: {
          size: true,
          opacity: true,
          particleSize: false,
          density: false,
        },
        spray: {
          size: true,
          opacity: true,
          particleSize: true,
          density: true,
        },
      },
    };
  },
  mounted() {
    this.canvas = this.$refs.canvas;
    this.canvasData = this.canvas.getBoundingClientRect();
    this.selectFrame(0);
    this.selectTool(this.toolsMetaData.crayon);
    this.drawingToolsData.currentColor = `rgba(0, 0, 0, ${this.drawingToolsData.currentOpacity/100})`;
    this.drawColorCanvas();
  },
  methods: {
    
    
    setCurrentSize(newValue) {
      this.drawingToolsData.currentSize = newValue;
    },

    selectOnionLayer(index) {
      this.onionLayerState[index] = false;
      this.displayOnionLayers();
    },
    
    unselectOnionLayer(index) {
      this.onionLayerState[index] = true;
      this.displayOnionLayers();
    },

    deleteSelectedFrame() {
      this.frames.splice(this.displayedFrame, 1);
      if(this.displayedFrame == this.frames.length) {
        this.displayedFrame--;
      }
      this.readCurrentFrame();
    },

    handleKeyPress(event) {
      console.log("keypress");
      if (event.key === 'ArrowRight') {
        this.nextFrame();
      }
    },

    createNewFrame() {
      this.calkLayers[this.selectedCalk].push({code: ""},);
    },

    duplicateSelectedFrame() {
      this.frames.push(this.frames[this.displayedFrame]);
    },

    updateFrameRate(event) {
      this.frameRate = parseInt(event.target.value);
    },

    play() {
      this.stop();
      this.videoBeingPlayed = true;
      this.interval = setInterval(() => {
        this.nextFrame();
      }, 1000/this.frameRate);
    },

    stop() {
      this.videoBeingPlayed = false;
      clearInterval(this.interval);
      this.readCurrentFrame();
    },
 
    nextFrame() {
      if(this.displayedFrame >= this.frames.length -1) {
        this.displayedFrame = 0;
      } else {
        this.displayedFrame++;
      }
      this.readCurrentFrame();
    },

    previousFrame() {
      if(this.displayedFrame == 0) {
        this.displayedFrame = this.frames.length -1;
      } else {
        this.displayedFrame--;
      }
      this.readCurrentFrame();
    },

    selectFrame(index) {
      this.displayedFrame = index;
      this.readCurrentFrame();
    },

    readCurrentFrame() {
      if (this.videoBeingPlayed) {
        const canvas = this.$refs.canvas;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        // Get the center coordinates of the canvas
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        console.log(centerX + centerY);
  
        eval(this.frames[this.displayedFrame].code);
      } else {
        this.displayOnionLayers();
      }
    },

    readNewStroke(newStroke) {
      const canvas = this.$refs.canvas;
      const ctx = canvas.getContext('2d');
      // Get the center coordinates of the canvas
      const centerX = canvas.width / 2;
      const centerY = canvas.height / 2;
      console.log(centerX + centerY + ctx);
  
      eval(newStroke);
    },

    displayOnionLayers() {
      const canvas = this.$refs.canvas;
      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      const originalFrame = this.displayedFrame;
      // Select the apropriate frame and draw the code
      for(let i = 0; i < 3; i++) {
        if(this.displayedFrame == 0) {
          this.displayedFrame = this.frames.length -1;
        } else {
          this.displayedFrame--;
        }
      }

      for(let i = 0; i < this.onionValue.length; i++) {
        if (this.onionLayerState[i]) {
          // Select the opacity on the onion layer
          ctx.globalAlpha = this.onionValue[i]/100;
          const centerX = canvas.width / 2;
          const centerY = canvas.height / 2;
          console.log(centerX + centerY);
          eval(this.frames[this.displayedFrame].code);
          // Go back to the selected frame
        }
        if(this.displayedFrame >= this.frames.length -1) {
          this.displayedFrame = 0;
        } else {
          this.displayedFrame++;
        }
      }
      this.displayedFrame = originalFrame;
      // Put back to opcatity of the main frame
      ctx.globalAlpha = this.onionValue[3]/100;
    },

    selectTool(tool) {
      this.drawingToolsData.currentTool = tool;
    },

    draw(event) {
      if(this.penDown) {
        const mouseX = event.clientX-this.canvasData.left;
        const mouseY = event.clientY-this.canvasData.top;

        if (this.drawingToolsData.currentTool === this.toolsMetaData.crayon) {
          //ctx.globalAlpha = "${this.drawingToolsData.currentOpacity/100}";
          const newStroke = `
            ctx.fillStyle = "${this.drawingToolsData.currentColor}";
            ctx.strokeStyle = "${this.drawingToolsData.currentColor}";
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            `;

          this.frames[this.displayedFrame].code += newStroke;
          this.readNewStroke(newStroke);

        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.spray) {

          for(let i = 0; i < this.drawingToolsData.currentDensity; i++) {

            let rawX = Math.random() * 2 - 1;
            let rawY = Math.random() * 2 - 1;
            let x = (rawX * Math.cos(rawY * (Math.PI*3))) * this.drawingToolsData.currentSize;
            let y = (rawY * Math.cos(rawX * (Math.PI*3))) * this.drawingToolsData.currentSize;

            //ctx.globalAlpha = "${this.drawingToolsData.currentOpacity/100}";
            const newStroke =
            `
              ctx.fillStyle = "${this.drawingToolsData.currentColor}";
              ctx.strokeStyle = "${this.drawingToolsData.currentColor}";
              ctx.beginPath();
              ctx.arc(${mouseX + x}, ${mouseY + y}, ${(this.drawingToolsData.currentParticleSize/10)*(this.drawingToolsData.currentSize/2)}, 0, Math.PI * 2);
              ctx.fill();
              ctx.closePath();
              `;
            
              this.frames[this.displayedFrame].code += newStroke;
              this.readNewStroke(newStroke);
          }
        }
      }
    },

    handleMouseDown(event) {
      //Update color opacity
      this.drawingToolsData.currentColor = `rgba(${this.drawingToolsData.currentRGB[0]}, ${this.drawingToolsData.currentRGB[1]}, ${this.drawingToolsData.currentRGB[2]}, ${this.drawingToolsData.currentOpacity/100})`; 
      this.canvasData = this.canvas.getBoundingClientRect();
      this.penDown = true;
      this.handleMouseMove(event);
    },

    handleMouseMove(event) {
      this.draw(event);
    },

    handleMouseUp() {
      this.penDown = false;
    },

    pickColorFromColorCanvas(event) {
      const canvas2 = this.$refs.colorCanvas;
      const ctx2 = canvas2.getContext('2d');
      const rectangle = this.$refs.colorCanvas.getBoundingClientRect();
      
      const x = event.clientX - rectangle.left;
      const y = event.clientY - rectangle.top;
      
      let palette = ctx2.getImageData(x, y, 1, 1);
      
      // Enregistrement des valeurs RGB.
      console.log(this.drawingToolsData.currentRGB);
      this.drawingToolsData.currentRGB[0] = palette.data[0];
      this.drawingToolsData.currentRGB[1] = palette.data[1];
      this.drawingToolsData.currentRGB[2] = palette.data[2];
    },

    drawColorCanvas() {
      const canvas2 = this.$refs.colorCanvas;
      const ctx2 = canvas2.getContext('2d');
  
      let gradient = ctx2.createLinearGradient(0, 0, canvas2.width, 0);
  
      // Dégradé rouge -> vert -> bleu horizontal.
      gradient.addColorStop(0, 'rgb(255,   0,   0)');
      gradient.addColorStop(0.15, 'rgb(255,   0, 255)');
      gradient.addColorStop(0.32, 'rgb(0,     0, 255)');
      gradient.addColorStop(0.49, 'rgb(0,   255, 255)');
      gradient.addColorStop(0.66, 'rgb(0,   255,   0)');
      gradient.addColorStop(0.83, 'rgb(255, 255,   0)');
      gradient.addColorStop(1, 'rgb(255,   0,   0)');
  
      ctx2.fillStyle = gradient;
      ctx2.fillRect(0, 0, canvas2.width, canvas2.height);
  
      gradient = ctx2.createLinearGradient(0, 0, 0, canvas2.height);
  
      // Dégradé blanc opaque -> transparent -> noir opaque vertical.
      gradient.addColorStop(0, 'rgba(255, 255, 255, 1)');
      gradient.addColorStop(0.5, 'rgba(255, 255, 255, 0)');
      gradient.addColorStop(0.5, 'rgba(0,     0,   0, 0)');
      gradient.addColorStop(1, 'rgba(0,     0,   0, 1)');
  
      ctx2.fillStyle = gradient;
      ctx2.fillRect(0, 0, canvas2.width, canvas2.height);
    },
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  * {
    box-sizing: border-box;
  }

  #upper-section {
    display: flex;
    justify-content: space-around;
  }

  .tool-section,
  canvas,
  #lower-section {
    border: 1px solid rgb(57, 57, 57);
    border-radius: 3px;
  }

  canvas:hover {
    cursor: crosshair;
  }

  #color-canvas {
    /*width: 100%;*/
  }

  #myCanvas {
    background-color: rgb(240, 240, 240);
  }

  .tool-section,
  #lower-section {
    background-color: rgb(186, 186, 186);
  }

  .tool-section {
    /*max-width: 200px;*/
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  #tool-parameters {
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid grey;
    background-color: rgb(152, 152, 152);
    border-radius: 3px;
    padding-top: 5px;
  }

  #tool-parameters div {
    display: flex;
    flex-direction: column;
  }

  #tool-parameters div + div {
    border-top: 1px dashed grey;
  }

  #tool-parameters label {
    font-size: 12px;
    opacity: 0.8;
    margin-left: 5px;
  }

  .tool-section-left {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    align-content: flex-start; 
    height: auto; /* Make the child element take all available height */
    box-sizing: border-box;
  }

  button img {
    max-height: 2rem;
    max-width: 2rem;
  }

  button {
    margin: 0.5rem;
    height: 3rem;
    cursor: pointer;
  }

  .tool-section-right {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  #onion-parameters {
    border: 1px solid grey;
    background-color: rgb(152, 152, 152);
    border-radius: 2px;
    display: flex;
  }

  .onion-layer {
    position: relative;
    height: 150px;
    /*border: 1px solid red;*/
    width: 40px;
  }
  .onion-layer + .onion-layer {
    border-left: 1px dashed grey;
  }
  .onion-slider {
    transform: rotate(-90deg);
    position: absolute;
    top: 45px;
    left: -34px;
    width: 100px;
  }

  .onion-layer button {
    position: absolute;
    height: 30px;
    width: 30px;
    bottom: -5px;
    left: -4px;
  }

  .onion-layer button img {
    max-height: 100%;
    max-width: 100%;
  }

  #video-controls {
    display: flex;
    justify-content: center;
  }

  #frame-parameters {
    margin-bottom: 0.5rem;
  }

  #frame-parameters input {
    width: 5rem;
    background-color: rgba(222, 222, 222, 0.847);
    border: 1px solid grey;
    border-radius: 3px;
    text-align: center;
  }

  #frame-parameters span {
    margin-right: 1rem;
  }

  #frame-parameters button {
    height: auto;
    background-color: rgba(255, 255, 255, 0.591);
    border: 1px solid grey;
    border-radius: 5px;
  }

  #timeline {
    /*border: 1px solid red;*/
  }

  #lower-section {
    min-height: 50px;
    padding: 3px;
    overflow: auto;
  }

  #lower-section button {
    margin: 1px;
  }

  .selected-frame, .selected {
    border: 2px solid rgb(58, 58, 173);
    border-radius: 3px;
    background-color: rgb(182, 182, 217);
  }

  .semi-selected-frame {
    background-color: rgb(182, 182, 217);
    border-radius: 3px;
    border: 2px solid rgb(139, 139, 139);
  }
 
</style>
