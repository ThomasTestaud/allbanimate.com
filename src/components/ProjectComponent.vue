<template>
 
  <div class="parameter-bar">
    <router-link to="/my-projects">My projects</router-link>
    <BtnSaveProject :projectData="{calkLayers,calkLayersEverCount,frameRate,drawingToolsData,memoryColorPalette,displayedFrame,selectedCalk,lineWidth,onionValue,onionLayerState,}"></BtnSaveProject>
    <BtnDownload :projectData="{calkLayers,frameRate}"/>
  </div>
    <div id="upper-section">
      <div class="tool-section">
        <div id="tool-parameters">
          <div v-if="drawingToolsData.currentTool.size === true">
            <label for="">Size: {{ drawingToolsData.currentSize }}</label>
            <input type="range" min="1" max="150" v-model="drawingToolsData.currentSize">
          </div>
          <div v-if="drawingToolsData.currentTool.opacity === true">
            <label for="">Opacity: {{ drawingToolsData.currentOpacity/100 }}</label>
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
          <button v-if="drawingToolsData.currentTool === toolsMetaData.crayon" class="selected"><img src="@/assets/sharpy.png" alt="crayon"></button>
          <button v-else @click="selectTool(toolsMetaData.crayon)"><img src="@/assets/sharpy.png" alt="crayon"></button>

          <button v-if="drawingToolsData.currentTool === toolsMetaData.spray" class="selected"><img src="@/assets/spray.png" alt="spray"></button>
          <button v-else @click="selectTool(toolsMetaData.spray)"><img src="@/assets/spray.png" alt="spray"></button>
          
          <button v-if="drawingToolsData.currentTool === toolsMetaData.three" class="selected"><img src="@/assets/crayon.png" alt="dots"></button>
          <button v-else @click="selectTool(toolsMetaData.three)"><img src="@/assets/crayon.png" alt="spray"></button>

          <button v-if="drawingToolsData.currentTool === toolsMetaData.scissors" class="selected"><img src="@/assets/scissors.png" alt="dots"></button>
          <button v-else @click="selectTool(toolsMetaData.scissors)"><img src="@/assets/scissors.png" alt="spray"></button>

          <button v-if="drawingToolsData.currentTool === toolsMetaData.eraser" class="selected"><img src="@/assets/eraser.png" alt="eraser"></button>
          <button v-else @click="selectTool(toolsMetaData.eraser)"><img src="@/assets/eraser.png" alt="spray"></button>
          
          <button v-if="drawingToolsData.currentTool === toolsMetaData.four" class="selected"><img src="@/assets/bucket.png" alt="bucket"></button>
          <button v-else @click="selectTool(toolsMetaData.four)"><img src="@/assets/bucket.png" alt="spray"></button>   
        </div>
        
        <div class="edit-section">
          <div>
            <div class="sub-text">Layer:</div> 
            <div>
              <button class="hover-tag-parent" @click="createNewLayer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <div class="hover-tag-children">
                  Create new layer
                </div>
              </button>
              <button class="hover-tag-parent selected" v-if="renamingLayer" @click="renameLayerFalse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                <div class="hover-tag-children">
                  Rename layers
                </div>
              </button>
              <button class="hover-tag-parent" v-else @click="renameLayerTrue">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                <div class="hover-tag-children">
                  Rename layers
                </div>
              </button>
              <button class="hover-tag-parent" @click="deleteSelectedLayer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                <div class="hover-tag-children">
                  Delete layer
                </div>
              </button>
            </div>
          </div>
          <div>
            <div class="sub-text">Frame:</div> 
            <div>
              <button class="hover-tag-parent" @click="createNewFrame">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <div class="hover-tag-children">
                  Create new frame
                </div>
              </button>
              <button @click="copyFrame" class="hover-tag-parent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" /></svg>
                <div class="hover-tag-children">
                  Copy frame
                </div>
              </button>
              <button @click="pasteFrame" class="hover-tag-parent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg>
                <div class="hover-tag-children">
                  Paste frame
                </div>
              </button>
              <button class="hover-tag-parent" @click="duplicateSelectedFrame">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <div class="hover-tag-children">
                  Duplicate selected frame
                </div>
              </button>
              <br>
              <button class="hover-tag-parent" @click="deleteSelectedFrame">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                <div class="hover-tag-children">
                  Delete selected frame
                </div>
              </button>
            </div>
          </div>
          <div>
            <div class="sub-text">Image:</div> 
            <div>
              <button class="hover-tag-parent" @click="blackCanvas">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <div class="hover-tag-children">
                  Create empty image
                </div>
              </button>
              <button class="hover-tag-parent" @click="copyImage">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" /></svg>
                <div class="hover-tag-children">
                  Copy image
                </div>
              </button>
              <button class="hover-tag-parent" @click="pasteImage">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg>
                <div class="hover-tag-children">
                  Paste image
                </div>
              </button>
              <button class="hover-tag-parent" @click="emptyCanvas">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                <div class="hover-tag-children">
                  Delete image
                </div>
              </button>
            </div>
          </div>
        </div>

      </div>

      <div class="canvas-container">

        <canvas ref="canvas" id="myCanvas" width="800" height="500"
        @mousedown="handleMouseDown" @mouseup="handleMouseUp" @mouseleave="handleMouseUp" @mousemove="handleMouseMove"></canvas>
        
        <div id="video-controls">
          <button @click="previousFrame"><img src="@/assets/leftskip.png" alt="leftskip"></button>
          <button @click="stop"><img src="@/assets/pause.png" alt="pause"></button>
          <button @click="play"><img src="@/assets/play.png" alt="play"></button>
          <button @click="nextFrame"><img src="@/assets/rightskip.png" alt="rightskip"></button>
        </div>

        <span id="frame-parameters">
          <label for="frame-rate">Frame rate: </label>
          <input type="number" id="frame-rate" v-model="frameRate" @keyup="updateFrameRate" @click="updateFrameRate">
          /s
        </span>
      </div>
      
      <div class="tool-section tool-section-right">
        <div id="color-tools">
          <canvas ref="colorCanvas" id="color-canvas" width="280" height="100" @click="pickColorFromColorCanvas"></canvas>
          <div id="memory-palette">
            <button v-for="(color, index) in memoryColorPalette" :key="index" :style="{ backgroundColor: color.string }" @click="setColor(color.rgb)"></button>
          </div>
        </div>
        <div id="onion-parameters" @mousemove="displayOnionLayers">
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[0]" class="onion-slider">
            <button v-if="onionLayerState[0] !== false" class="selected" @click="selectOnionLayer(0)"><img src="@/assets/onoin-3.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(0)"><img src="@/assets/onoin-3.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[1]" class="onion-slider">
            <button v-if="onionLayerState[1] !== false" class="selected" @click="selectOnionLayer(1)"><img src="@/assets/onoin-2.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(1)"><img src="@/assets/onoin-2.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[2]" class="onion-slider">
            <button v-if="onionLayerState[2] !== false" class="selected" @click="selectOnionLayer(2)"><img src="@/assets/onoin-1.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(2)"><img src="@/assets/onoin-1.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="100" v-model="onionValue[3]" class="onion-slider">
            <button v-if="onionLayerState[3] !== false" class="selected" @click="selectOnionLayer(3)"><img src="@/assets/onion.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(3)"><img src="@/assets/onion.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[4]" class="onion-slider">
            <button v-if="onionLayerState[4] !== false" class="selected" @click="selectOnionLayer(4)"><img src="@/assets/onoin+1.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(4)"><img src="@/assets/onoin+1.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[5]" class="onion-slider">
            <button v-if="onionLayerState[5] !== false" class="selected" @click="selectOnionLayer(5)"><img src="@/assets/onoin+2.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(5)"><img src="@/assets/onoin+2.png" alt="onion"></button>
          </div>
          <div class="onion-layer">
            <input type="range" min="1" max="20" v-model="onionValue[6]" class="onion-slider">
            <button v-if="onionLayerState[6] !== false" class="selected" @click="selectOnionLayer(6)"><img src="@/assets/onoin+3.png" alt="onion"></button>
            <button v-else @click="unselectOnionLayer(6)"><img src="@/assets/onoin+3.png" alt="onion"></button>
          </div>
        </div>
      </div>
    </div>
    
    <!--
    <div id="frame-parameters">
      <span class="params">
        <button @click="createNewLayer">Create new layer</button>
        <button @click="deleteSelectedLayer">Delete selected layer</button>
        <button v-if="renamingLayer" @click="renameLayerFalse" class="selected">Rename layer</button>
        <button v-else @click="renameLayerTrue">Rename layer</button>
      </span>
      <span class="params">
        <button @click="createNewFrame">Create new frame</button>
        <button @click="duplicateSelectedFrame">Duplicate selected frame</button>
        <button @click="deleteSelectedFrame">Delete selected frame</button>
      </span>
      <span style="margin-right:5px;">
        <label for="frame-rate">Frame rate: </label>
        <input type="number" id="frame-rate" v-model="frameRate" @keyup="updateFrameRate" @click="updateFrameRate">
        /s
      </span>
    </div>-->

    <div id="lower-section">
      <div id="timeline" @click="readCurrentFrame">
        <div v-for="(calk, calkIndex) in calkLayers" :key="calk" class="layer" @click="selectedCalk = calkIndex">
          <span v-if="calkIndex == selectedCalk" class="layer-head layer-head-selected">
            <div class="layer-name" v-if="renamingLayer">
              <input type="text" v-model="calk.name">  
            </div>
            <div class="layer-name" v-else>{{ calk.name }}</div>
            <div class="layer-arrows">
              <button @click="moveLayerTowardTop(calkIndex)">
                <img  src="@/assets/arrow-up.png" alt="arrow-up">
              </button>
              <button @click="moveLayerTowardBottom(calkIndex)">
                <img  src="@/assets/arrow-down.png" alt="arrow-down">
              </button>
            </div>
            <button @click="hideCalkLayer(calkIndex)" v-if="calkLayers[calkIndex].displayed == true">
              <img src="@/assets/open-eye.png" alt="open-eye">
            </button>
            <button @click="displayCalkLayer(calkIndex)" v-else>
              <img src="@/assets/closed-eye.png" alt="closed-eye">
            </button>
            <button @click="hideOnionLayer(calkIndex)" v-if="calkLayers[calkIndex].onion == true">
              <img src="@/assets/onion.png" alt="onion">
            </button>
            <button @click="displayOnionLayer(calkIndex)" v-else>
              <img src="@/assets/onion-cross.png" alt="onion">
            </button>
          </span>
          <span v-else class="layer-head">
            <div class="layer-name">{{ calk.name }}</div>
            <div class="layer-arrows">
              <button @click="moveLayerTowardTop(calkIndex)">
                <img  src="@/assets/arrow-up.png" alt="arrow-up">
              </button>
              <button @click="moveLayerTowardBottom(calkIndex)">
                <img  src="@/assets/arrow-down.png" alt="arrow-down">
              </button>
            </div>
            <button @click="hideCalkLayer(calkIndex)" v-if="calkLayers[calkIndex].displayed == true">
              <img src="@/assets/open-eye.png" alt="open-eye">
            </button>
            <button v-else>
              <img @click="displayCalkLayer(calkIndex)" src="@/assets/closed-eye.png" alt="closed-eye">
            </button>
            <button @click="hideOnionLayer(calkIndex)" v-if="calkLayers[calkIndex].onion == true">
              <img src="@/assets/onion.png" alt="onion">
            </button>
            <button @click="displayOnionLayer(calkIndex)" v-else>
              <img src="@/assets/onion-cross.png" alt="onion">
            </button>
          </span>
          <span class="frame" v-for="(frame, index) in calk.code" :key="frame" @click="selectFrame(index)">
            <button v-if="index == displayedFrame && calkIndex == selectedCalk && frame === ''" class="empty-selected-frame"></button>
            <button v-else-if="index == displayedFrame && calkIndex == selectedCalk && frame !== ''" class="selected-frame"></button>
            <button v-else-if="index == displayedFrame && calkIndex !== selectedCalk && frame === ''" class="empty-semi-selected-frame"></button>
            <button v-else-if="index == displayedFrame && calkIndex !== selectedCalk && frame !== ''" class="semi-selected-frame"></button>
            <button v-else-if="frame === ''" class="empty-frame"></button>
            <button v-else></button>
          </span>
        </div>
      </div>
    </div>
</template>

<script>

import BtnSaveProject from '../components/BtnSaveProject.vue';
import BtnDownload from '../components/BtnDownload.vue';

export default {
  name: 'projectComponent',
  components: {
    BtnSaveProject,
    BtnDownload,
  },
  props: {
    projectData: Object,
  },
  data() {
    return {
      calkLayers: this.projectData.calkLayers,
      calkLayersEverCount: this.projectData.calkLayersEverCount,
      frameRate: this.projectData.frameRate,
      drawingToolsData: this.projectData.drawingToolsData,
      memoryColorPalette: this.projectData.memoryColorPalette,
      displayedFrame: this.projectData.displayedFrame,
      selectedCalk: this.projectData.selectedCalk,
      lineWidth: this.projectData.lineWidth,
      onionValue: this.projectData.onionValue,
      onionLayerState: this.projectData.onionLayerState,
      
      copiedFrame: null,
      copiedImage: null,
      interval: null,
      canvas: null,
      canvasData: null,
      penDown: false,
      lastPenPosition: null,
      videoBeingPlayed: false,
      renamingLayer: false,
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
        three: {
          size: true,
          opacity: true,
          particleSize: false,
          density: false,
        },
        four: {
          size: true,
          opacity: true,
          particleSize: false,
          density: false,
        },
        eraser: {
          size: true,
          opacity: false,
          particleSize: false,
          density: false,
        },
        scissors: {
          size: true,
          opacity: true,
          particleSize: false,
          density: false,
        },
      },
    };
  },
  mounted() {
    this.canvas = this.$refs.canvas;
    this.canvasData = this.canvas.getBoundingClientRect();
    //this.selectFrame(0);
    this.selectTool(this.toolsMetaData.crayon);
    this.drawingToolsData.currentColor = `rgba(0, 0, 0, ${this.drawingToolsData.currentOpacity/100})`;
    this.drawColorCanvas();
    this.readCurrentFrame();
  },
  methods: {

    pasteImage() {
      if(this.copiedImage !== null) {
        this.calkLayers[this.selectedCalk].code[this.displayedFrame] = this.calkLayers[this.copiedImage[1]].code[this.copiedImage[0]]
        this.readCurrentFrame();
      }
    },

    copyImage() {
      this.copiedImage = [this.displayedFrame, this.selectedCalk];
    },

    pasteFrame() {
      if(this.copiedFrame !== null) {
        this.calkLayers.forEach((element) => {
          element.code[this.displayedFrame] = element.code[this.copiedFrame];
        });
        this.readCurrentFrame();
      }
    },

    copyFrame() {
      this.copiedFrame = this.displayedFrame;
    },

    renameLayerTrue() {
      this.renamingLayer = true;
    },

    renameLayerFalse() {
      this.renamingLayer = false;
    },

    displayOnionLayer(calkIndex) {
      this.calkLayers[calkIndex].onion = true;
    },

    hideOnionLayer(calkIndex) {
      this.calkLayers[calkIndex].onion = false;
    },

    displayCalkLayer(calkIndex) {
      this.calkLayers[calkIndex].displayed = true;
    },

    hideCalkLayer(calkIndex) {
      this.calkLayers[calkIndex].displayed = false;
    },

    moveLayerTowardTop(calkIndex) {
      if(calkIndex < this.calkLayers.length -1) {
        [this.calkLayers[calkIndex], this.calkLayers[calkIndex + 1]] = [this.calkLayers[calkIndex + 1], this.calkLayers[calkIndex]];
      }
    },

    moveLayerTowardBottom(calkIndex) {
      if(calkIndex > 0) {
        [this.calkLayers[calkIndex - 1], this.calkLayers[calkIndex]] = [this.calkLayers[calkIndex], this.calkLayers[calkIndex - 1]];
      }
    },

    createNewLayer() {
      // Update the everCount
      this.calkLayersEverCount++;
      // Initiate the frames array to match to project's current amount of frames
      const framesArray = [];
      this.calkLayers[0].code.forEach(() => {
        framesArray.push("");
      });
      // Write and push the new layer
      this.calkLayers.push(
        {
          code: framesArray,
          displayed: true,
          onion: true,
          name: "Layer " + this.calkLayersEverCount,
        },
      );

      this.selectedCalk = this.calkLayers.length-1;
    },

    deleteSelectedLayer() {
      this.calkLayers.splice(this.selectedCalk, 1);
    },

    blackCanvas() {
      this.calkLayers[this.selectedCalk].code[this.displayedFrame] = "/**/";
      this.readCurrentFrame();
    },

    emptyCanvas() {
      this.calkLayers[this.selectedCalk].code[this.displayedFrame] = "";
      this.readCurrentFrame();
    },
    
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
      //this.calkLayers[this.selectedCalk].splice(this.displayedFrame, 1);
      this.calkLayers.forEach((layer) => {
        layer.code.splice(this.displayedFrame, 1);
      });
      if(this.displayedFrame == this.calkLayers[this.selectedCalk].code.length) {
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
      this.calkLayers.forEach((layer) => {
        layer.code.push("");
      });
    },

    duplicateSelectedFrame() {
      //this.calkLayers[this.selectedCalk].push(this.calkLayers[this.selectedCalk][this.displayedFrame]);
      this.calkLayers.forEach((layer) => {
        layer.code.push(layer.code[this.displayedFrame]);
      });
    },

    updateFrameRate(event) {
      this.frameRate = parseInt(event.target.value);
    },

 
    nextFrame() {
      if(this.displayedFrame >= this.calkLayers[this.selectedCalk].code.length -1) {
        this.displayedFrame = 0;
      } else {
        this.displayedFrame++;
      }
      this.readCurrentFrame();
    },

    previousFrame() {
      if(this.displayedFrame == 0) {
        this.displayedFrame = this.calkLayers[this.selectedCalk].code.length -1;
      } else {
        this.displayedFrame--;
      }
      this.readCurrentFrame();
    },

    selectFrame(index) {
      this.displayedFrame = index;
      this.readCurrentFrame();
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

    returnLastDrawnedFrameFrom(layer, frame) {
      if(this.calkLayers[layer].code[frame] !== "") {
        return this.calkLayers[layer].code[frame];
      }
      if(frame === 0) {
        return this.calkLayers[layer].code[frame];
      }
      return this.returnLastDrawnedFrameFrom(layer, frame-1);
    },

    readCurrentFrame() {
      //console.log(this.canvas.toDataURL('image/png'));
      if (this.videoBeingPlayed) {
        const canvas = this.$refs.canvas;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        // Get the center coordinates of the canvas
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        console.log(centerX + centerY);
        
        this.calkLayers.forEach((layer, index) => {
          if(layer.displayed) {
            eval(this.returnLastDrawnedFrameFrom(index, this.displayedFrame));
          }
        });

      } else {
        this.displayOnionLayers();
      }
    },

    displayOnionLayers() {

      const canvas = this.$refs.canvas;
      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      const originalFrame = this.displayedFrame;

      this.calkLayers.forEach((layer, index) => {
        if(layer.displayed) {
          // Select the apropriate frame and draw the code
          for(let i = 0; i < 3; i++) {
            if(this.displayedFrame == 0) {
              this.displayedFrame = this.calkLayers[this.selectedCalk].code.length -1;
            } else {
              this.displayedFrame--;
            }
          }
          for(let i = 0; i < this.onionValue.length; i++) {
            ctx.globalAlpha = this.onionValue[i]/100;
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            console.log(centerX + centerY);
            if (this.onionLayerState[i] && layer.onion) {
              eval(this.returnLastDrawnedFrameFrom(index, this.displayedFrame));
            } else if (layer.onion === false && this.onionLayerState[i] && i == 3 ) {
              
              eval(this.returnLastDrawnedFrameFrom(index, this.displayedFrame));
            }
            // Go back to the selected frame
            if(this.displayedFrame >= this.calkLayers[this.selectedCalk].code.length -1) {
              this.displayedFrame = 0;
            } else {
              this.displayedFrame++;
            }
          }
          this.displayedFrame = originalFrame;
        }
      });
      // Put back to opcatity of the main frame
      ctx.globalAlpha = this.onionValue[3]/100;
    },

    selectTool(tool) {
      this.drawingToolsData.currentTool = tool;
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

    draw(event) {
      if(this.penDown && this.calkLayers[this.selectedCalk].displayed) {
        
        const mouseX = event.clientX-this.canvasData.left;
        const mouseY = event.clientY-this.canvasData.top;

        // If the frame we are about to draw onto is empty, copy the code from the last frawing onto it
        if(this.calkLayers[this.selectedCalk].code[this.displayedFrame] == "") {
          this.calkLayers[this.selectedCalk].code[this.displayedFrame] = this.returnLastDrawnedFrameFrom(this.selectedCalk, this.displayedFrame)
        }

        if (this.drawingToolsData.currentTool === this.toolsMetaData.crayon) {

          let newStroke = `
            ctx.fillStyle = "${this.drawingToolsData.currentColor}";
            ctx.strokeStyle = "${this.drawingToolsData.currentColor}";
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            `;

          if(this.lastPenPosition !== null) {
            newStroke += `ctx.lineWidth = ${this.drawingToolsData.currentSize*2};
                          ctx.beginPath();
                          ctx.moveTo(${this.lastPenPosition[0]}, ${this.lastPenPosition[1]});
                          ctx.lineTo(${mouseX}, ${mouseY});
                          ctx.stroke();`;
          }

          this.lastPenPosition = [mouseX, mouseY];

          this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
          this.readNewStroke(newStroke);

        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.spray) {

          for(let i = 0; i < this.drawingToolsData.currentDensity/10; i++) {

            let rawX = Math.random() * 2 - 1;
            let rawY = Math.random() * 2 - 1;
            let x = (rawX * Math.cos(rawY * (Math.PI*3))) * this.drawingToolsData.currentSize;
            let y = (rawY * Math.cos(rawX * (Math.PI*3))) * this.drawingToolsData.currentSize;

            const newStroke =
            `
              ctx.fillStyle = "${this.drawingToolsData.currentColor}";
              ctx.strokeStyle = "${this.drawingToolsData.currentColor}";
              ctx.beginPath();
              ctx.arc(${mouseX + x}, ${mouseY + y}, ${(this.drawingToolsData.currentParticleSize/10)*(this.drawingToolsData.currentSize/2)}, 0, Math.PI * 2);
              ctx.fill();
              ctx.closePath();
              `;
            
              this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
              this.readNewStroke(newStroke);
          }
        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.three) {

          const newStroke = `
            ctx.fillStyle = "rgba(${this.drawingToolsData.currentRGB}, ${this.drawingToolsData.currentOpacity/200})";
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/2}, 0, Math.PI * 2);
            ctx.arc(${mouseX - this.drawingToolsData.currentSize/(1+Math.random()*2)}, ${mouseY - this.drawingToolsData.currentSize/(1+Math.random()*1.5)}, ${this.drawingToolsData.currentSize/1.5}, 0, Math.PI * 2);
            ctx.arc(${mouseX + this.drawingToolsData.currentSize/(1+Math.random()*2)}, ${mouseY - this.drawingToolsData.currentSize/(1+Math.random()*1.5)}, ${this.drawingToolsData.currentSize/1.5}, 0, Math.PI * 2);
            ctx.arc(${mouseX + this.drawingToolsData.currentSize/(1+Math.random()*3)}, ${mouseY + this.drawingToolsData.currentSize/(1+Math.random()*1.5)}, ${this.drawingToolsData.currentSize/2.5}, 0, Math.PI * 2);
            ctx.arc(${mouseX - this.drawingToolsData.currentSize/(1+Math.random()*3)}, ${mouseY + this.drawingToolsData.currentSize/(1+Math.random()*2.5)}, ${this.drawingToolsData.currentSize/2.5}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            `;

          this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
          this.readNewStroke(newStroke);

        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.scissors) {
          
          const newStroke = `
            ctx.fillStyle = "rgba(${this.drawingToolsData.currentRGB}, ${this.drawingToolsData.currentOpacity/1000})";
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/4.5}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/4}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/3.5}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/3}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSiz/2.5}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/2}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize/1.5}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            ctx.beginPath();
            ctx.arc(${mouseX}, ${mouseY}, ${this.drawingToolsData.currentSize}, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
            `;

          this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
          this.readNewStroke(newStroke);

        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.four) {

          const newStroke = `
            ctx.fillStyle = "${this.drawingToolsData.currentColor}";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            `;

          this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
          this.readNewStroke(newStroke);

        } else if (this.drawingToolsData.currentTool === this.toolsMetaData.eraser) {

          const newStroke = `
            ctx.clearRect(${mouseX} - ${this.drawingToolsData.currentSize}, ${mouseY} - ${this.drawingToolsData.currentSize}, ${this.drawingToolsData.currentSize} * 2, ${this.drawingToolsData.currentSize} * 2);
            `;

          this.calkLayers[this.selectedCalk].code[this.displayedFrame] += newStroke;
          this.readNewStroke(newStroke);
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
      this.lastPenPosition = null;
    },

    setColor(color) {
      this.drawingToolsData.currentRGB[0] = color[0];
      this.drawingToolsData.currentRGB[1] = color[1];
      this.drawingToolsData.currentRGB[2] = color[2];
    },

    pickColorFromColorCanvas(event) {
      const canvas2 = this.$refs.colorCanvas;
      const ctx2 = canvas2.getContext('2d');
      const rectangle = this.$refs.colorCanvas.getBoundingClientRect();
      
      const x = event.clientX - rectangle.left;
      const y = event.clientY - rectangle.top;
      
      let palette = ctx2.getImageData(x, y, 1, 1);
      
      // Enregistrement des valeurs RGB.
      this.drawingToolsData.currentRGB[0] = palette.data[0];
      this.drawingToolsData.currentRGB[1] = palette.data[1];
      this.drawingToolsData.currentRGB[2] = palette.data[2];

      //this.drawingToolsData.currentColor = `rgba(${this.drawingToolsData.currentRGB[0]}, ${this.drawingToolsData.currentRGB[1]}, ${this.drawingToolsData.currentRGB[2]}, ${this.drawingToolsData.currentOpacity/100})`;

      // Update memory palette
      this.memoryColorPalette.unshift({
        string:`rgb(${this.drawingToolsData.currentRGB[0]}, ${this.drawingToolsData.currentRGB[1]}, ${this.drawingToolsData.currentRGB[2]})`, 
        rgb: [palette.data[0], palette.data[1], palette.data[2]]}
      );
      if (this.memoryColorPalette.length >= 52) {
        this.memoryColorPalette.pop();
      }
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
    margin-bottom: 10px;
  }

  .tool-section,
  #myCanvas,
  #lower-section {
    border: 2px solid var(--border-color);
    border-radius: 3px;
    color: white;
  }

  canvas:hover {
    cursor: crosshair;
  }

  #myCanvas {
    background-color: rgb(240, 240, 240);
  }

  .tool-section,
  #lower-section {
    background-color: var(--element-background-color);
  }

  .tool-section {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    max-height: 504px;
  }

  #tool-parameters {
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid var(--border-color);
    background-color: var(--element2-background-color);
    border-radius: 3px;
    padding-top: 5px;
  }

  #tool-parameters div {
    display: flex;
    flex-direction: column;
  }

  #tool-parameters div + div {
    border-top: 1px dashed var(--border-color);
  }

  #tool-parameters label,
  .sub-text {
    font-size: 12px;
    opacity: 0.8;
    margin-left: 5px;
  }

  .tool-section-left {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    align-content: flex-start; 
    height: auto;
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
    border: 2px solid var(--border-color);
    border-radius: 3px;
    background-color: var(--button-color);
  }

  .tool-section-right {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  #onion-parameters {
    border-top: 1px solid var(--border-color);
    background-color: var(--element2-background-color);
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
    border-left: 1px dashed var(--border-color);
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
    margin: auto;
  }

  #video-controls button {
    height: 35px;
    width: 35px;
    padding: 2px;
    margin: 0px;
  }

  #video-controls img {
    height: 100%;
  }

  .canvas-container {
    position: relative;
  }

  #frame-parameters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    bottom: 15px;
    right: -6px;
  }

  #frame-parameters input {
    width: 5rem;
    background-color: var(--button-color);
    border: 1px solid var(--border-color);
    border-radius: 3px;
    text-align: center;
  }

  #frame-parameters span {
    margin-right: 0rem;
  }

  #frame-parameters button {
    height: auto;
    background-color: var(--button-color);
    border: 1px solid var(--border-color);
    border-radius: 5px;
  }

  #timeline {
    display: flex;
    flex-direction: column;
    flex-direction: column-reverse;
  }

  #lower-section {
    padding: 0px 3px;
    overflow: auto;
    border-radius: 2px;
  }

  #lower-section button {
    margin: 1px;
  }

  #lower-section, #frame-parameters {
    margin: 0px 8px;
    color: white;
  }

  #frame-parameters button {
    margin: 2px;
  }

  #frame-parameters .params {
    border: 2px solid var(--border-color);
    border-bottom: 1px solid var(--element-background-color);
    background-color: var(--element-background-color);
    position: relative;
    top: 2px;
    min-height: 25px;
  }

  .selected-frame, .selected {
    border: 2px solid var(--selected-border);
    border-radius: 3px;
  }

  .selected {
    background-color: var(--selected-background);
  }

  .semi-selected-frame {
    background-color: var(--button-color);
    border-radius: 3px;
    border: 2px solid var(--selected-background);
  }

  .empty-selected-frame {
    background-color: inherit;
    border-radius: 3px;
    border: 2px solid var(--selected-border);
  }
  .empty-semi-selected-frame {
    background-color: inherit;
    border-radius: 3px;
    border: 2px solid var(--selected-background);
  }

  .empty-frame {
    background-color: rgba(182, 182, 217, 0);
    border-radius: 3px;
    border: 2px solid var(--border-color);
  }

  .layer {
    display: flex;
    align-items: center;
    padding: 1px 0px;
  }

  .layer + .layer {
    border-bottom: 1px dashed var(--border-color);
  }

  .layer-name {
    width: 90px;
    overflow: hidden;
    font-size: 12px;
  }

  .layer-name input {
    font-size: 12px;
    width: 80px;
  }

  .layer-head {
    display: flex;
    align-items: center;
    justify-content: space-around;
    height: auto;
    border: 2px solid var(--border-color);
    border-radius: 3px;
    background-color: var(--element2-background-color);
    padding: 4px;
    position: sticky;
    left: 0px;
    height: 48px;
    margin-right: 2px;
    color: white;
  }

  .frame {
    height: 50px;
  }

  .layer-head-selected {
    border: 2px solid var(--selected-border);
    background-color: var(--selected-background);
  }
  .layer-arrows {
    display: flex;
    flex-direction: column;
  }

  .layer-head button {
    height: 2rem;
    width: 2rem;
  }
  .layer-head img {
    height: 1rem;
    width: 1rem;
  }
  
  .layer-arrows button {
    height: 15px;
  }
  .layer-arrows img {
    height: 100%;
    width: 1rem;
  }

  #memory-palette {
    /*width: 260px;*/
    /*margin: auto;*/
    padding-left: 1px;
    display: grid;
    grid-template-columns: repeat(17, 1fr);
    grid-gap: 1px;
  }

  #memory-palette button {
    margin: 0px;
    padding: 0px;
    height: 15px;
    width: 15px;
  }

  .edit-section {
    background-color: var(--element2-background-color);
    border-top: 1px solid var(--border-color);
    border-radius: 3px;
  }

  .edit-section button {
    height: 30px;
    width: 30px;
    padding: 0px;
    margin: 2px;
  }

  .edit-section svg {
    height: 100%;
  }

  .edit-section > div + div {
    border-top: 1px dashed var(--border-color);
  }

  .hover-tag-parent {
    position: relative;
  }

  .hover-tag-children {
    display: none;
    opacity: 0;
    position: absolute;
    top: -1px;
    right: 20px;
    transform: translate(100%, -100%);
    transition: opacity 0.2s;
    background-color: var(--element-background-color);
    color: white;
    border: 2px solid var(--border-color);
    border-radius: 5px;
    z-index: 2;
    white-space: nowrap;
    padding: 3px;
  }

  
  .hover-tag-parent:hover .hover-tag-children {
    display: flex;
    opacity: 1;
  }
  .hover-tag-parent:hover .hover-tag-children:hover {
    display: none;
    opacity: 0;
  }

  @media (max-width: 1220px) {
    #upper-section {
      flex-wrap: wrap;
      justify-content: space-evenly;
    }
  
    #upper-section > div:nth-child(1) {
      order: 1; 
    }

    #upper-section > div:nth-child(2) {
      order: 3; 
    }

    #upper-section > div:nth-child(3) {
      order: 2;
    }

  }
</style>
