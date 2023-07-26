<template>
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
    </div>
    <canvas ref="canvas" id="myCanvas" width="800" height="500"
    @mousedown="handleMouseDown" @mouseup="handleMouseUp"></canvas>
    <div class="tool-section"><p>Here more tools coming up...</p></div>
  </div>
  <div id="video-controls">
    <button><img src="@/assets/left.png" alt="left"></button>
    <button @click="stop"><img src="@/assets/stop.png" alt="stop"></button>
    <button @click="play"><img src="@/assets/play.png" alt="play"></button>
    <button @click="nextFrame"><img src="@/assets/right.png" alt="right"></button>
  </div>
  <div id="lower-section">
    <div id="timeline"></div>
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
        {code: "const dotSize = 5;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
        {code: "const dotSize = 1;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
        {code: "const dotSize = 6;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
        {code: "const dotSize = 2;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
        {code: "const dotSize = 10;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
        {code: "const dotSize = 30;const dotColor = 'red';ctx.beginPath();ctx.arc(centerX, centerY, dotSize, 0, Math.PI * 2);ctx.fillStyle = dotColor;ctx.fill();ctx.closePath();"},
      ],
      frameRate: 3,
      displayedFrame: 0,
      interval: null,
      canvas: null,
      canvasData: null,
      lineWidth: 10,
    };
  },
  mounted() {
    this.canvas = this.$refs.canvas;
    this.canvasData = this.canvas.getBoundingClientRect();
    console.log(this.canvasData);
    this.nextFrame();
  },
  methods: {

    play() {
      this.interval = setInterval(() => {
        this.nextFrame();
      }, 1000/this.frameRate);
    },

    stop() {
      clearInterval(this.interval);
    },

    nextFrame() {
      const canvas = this.canvas;
      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      // Get the center coordinates of the canvas
      const centerX = canvas.width / 2;
      const centerY = canvas.height / 2;
      console.log(centerX + centerY);

      if(this.displayedFrame >= this.frames.length -1) {
        this.displayedFrame = 0;
      } else {
        this.displayedFrame++;
      }
      eval(this.frames[this.displayedFrame].code);
    },

    readCurrentFrame() {
      const canvas = this.$refs.canvas;
      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      // Get the center coordinates of the canvas
      const centerX = canvas.width / 2;
      const centerY = canvas.height / 2;
      console.log(centerX + centerY);

      
      eval(this.frames[this.displayedFrame].code);
    },

    handleMouseDown(event) {
      const mouseX = event.clientX-this.canvasData.left;
      const mouseY = event.clientY-this.canvasData.top;

      this.frames[this.displayedFrame].code +=
        `ctx.beginPath();
        ctx.arc(${mouseX}, ${mouseY}, ${this.lineWidth}, 0, Math.PI * 2);
        ctx.fill();ctx.closePath();`;

      this.readCurrentFrame();
    },

    handleMouseUp() {
      console.log('mouseup');
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
    max-width: 200px;
  }

  .tool-section-left {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    align-content: flex-start; 
  }

  button img {
    height: 2rem;
    width: 2rem;
  }

  button {
    margin: 0.5rem;
    height: 3rem;
    cursor: pointer;
  }

  #video-controls {
    display: flex;
    justify-content: center;
  }

  #lower-section {
    min-height: 50px;
  }
</style>
