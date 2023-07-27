<template>
  <div @keydown="handleKeyPress">
    <div id="upper-section">
      <div class="tool-section tool-section-left">
        <button><img src="@/assets/crayon.png" alt="crayon"></button>
        <button><img src="@/assets/spray.png" alt="spray"></button>
        <button><img src="@/assets/eraser.png" alt="eraser"></button>
        <button><img src="@/assets/pipette.png" alt="pipette"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/dots.png" alt="dots"></button>
        <button><img src="@/assets/clearcanvas.png" alt="clearcanvas"></button>
      </div>
      <canvas ref="canvas" id="myCanvas" width="800" height="500"
      @mousedown="handleMouseDown" @mouseup="handleMouseUp" @mousemove="handleMouseMove"></canvas>
      <div class="tool-section">
        <p>Here more tools coming up...</p>
        <div id="onion-parameters">
          <button><img src="@/assets/onoin-3.png" alt="onion"></button>
          <button><img src="@/assets/onoin-2.png" alt="onion"></button>
          <button><img src="@/assets/onoin-1.png" alt="onion"></button>
          <button><img src="@/assets/onion.png" alt="onion"></button>
          <button><img src="@/assets/onoin+1.png" alt="onion"></button>
          <button><img src="@/assets/onoin+2.png" alt="onion"></button>
          <button><img src="@/assets/onoin+3.png" alt="onion"></button>
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
        <button>Duplicate selected frame</button>
        <button @click="deleteSelectedFrame">Delete selected frame</button>
      </span>
    </div>
    <div id="lower-section">
      <div id="timeline">
        <div class="layer">
          <span class="frame" v-for="(frame, index) in frames" :key="frame.code" @click="selectFrame(index)">
            <button v-if="index == displayedFrame" class="selected-frame"></button>
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
      ],
      frameRate: 3,
      drawingToolsData: {
        currentColor: 'blue',
      },
      displayedFrame: 0,
      interval: null,
      canvas: null,
      canvasData: null,
      lineWidth: 10,
      penDown: false,
      videoBeingPlayed: false,
      onion: [0.01, 0.05, 0.1, 1, false, false, false],
    };
  },
  mounted() {
    this.canvas = this.$refs.canvas;
    this.canvasData = this.canvas.getBoundingClientRect();
    this.selectFrame(0);
  },
  methods: {

    deleteSelectedFrame() {
      this.frames.splice(this.displayedFrame, 1);
      if(this.displayedFrame == this.frames.length) {
        this.displayedFrame--;
      }
      this.readCurrentFrame();
    },

    handleKeyPress(event) {
      if (event.key === 'ArrowRight') {
        this.nextFrame();
      }
    },

    createNewFrame() {
      this.frames.push({code: ""},);
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

      for(let i = 0; i < this.onion.length; i++) {
        if (this.onion[i] !== false) {
          // Select the opacity on the onion layer
          ctx.globalAlpha = this.onion[i];
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
      ctx.globalAlpha = this.onion[3];
    },

    handleMouseDown(event) {
      this.penDown = true;
      this.handleMouseMove(event);
    },

    handleMouseMove(event) {
      if(this.penDown) {
        const mouseX = event.clientX-this.canvasData.left;
        const mouseY = event.clientY-this.canvasData.top;

        this.frames[this.displayedFrame].code +=
          `
          ctx.fillStyle = "${this.drawingToolsData.currentColor}";
          ctx.strokeStyle = "${this.drawingToolsData.currentColor}";
          ctx.beginPath();
          ctx.arc(${mouseX}, ${mouseY}, ${this.lineWidth}, 0, Math.PI * 2);
          ctx.fill();
          ctx.closePath();
          `;

        this.readCurrentFrame();
      }
    },

    handleMouseUp() {
      this.penDown = false;
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
  }

  canvas {
    width: 800px;
    height: 500px;
    background-color: rgb(240, 240, 240);
  }

  .tool-section,
  #lower-section {
    background-color: rgb(186, 186, 186);
  }

  .tool-section {
    /*max-width: 200px;*/
  }

  .tool-section-left {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    align-content: flex-start; 
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

  #onion-parameters {
    border: 1px solid grey;
    background-color: rgb(152, 152, 152);
    border-radius: 2px;
  }

  #onion-parameters button {
    margin: 2px;
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

  .selected-frame {
    border: 2px solid rgb(58, 58, 173);
    border-radius: 3px;
    background-color: rgb(182, 182, 217);
  }
</style>
