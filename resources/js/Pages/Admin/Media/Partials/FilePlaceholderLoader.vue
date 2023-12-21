<template>
  <div class="file-container">
    <p class="placeholder-glow img">
      <span class="placeholder col-10 placeholder-lg"></span>
    </p>
    <p class="placeholder-glow filename">
      <span class="placeholder col-7"></span>
    </p>
    <p class="placeholder-glow human-size">
      <span class="placeholder col-4 placeholder-sm"></span>
    </p>
  </div>
</template>

<style scoped>
.file-container {
  margin: 6px;
  width: 150px;
  height: 150px;
  border: 1px dashed #d2d6de;
  border-radius: 6px;
  text-align: center;
  padding-top: 12px;
}
.placeholder-lg {
  min-height: 5.2em;
  border-radius: 3px;
}
.img {
  margin: 0;
}
.filename {
  margin: 5px 0 1px;
}
.human-size {
  margin: 0;
}
</style>