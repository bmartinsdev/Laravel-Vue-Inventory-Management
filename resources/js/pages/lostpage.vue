<template>
  <div class="content">
    <div class="main align-items-center mt-4 justify-content-center d-flex flex-column">
				<h1 class="display-3">404 =(</h1>
				<h2 class="mt-1">Página não encontrada.</h2>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
			loop: null,
			colors: ["yellow", "blue", "red", ""],
			iteration: 0,
    };
  },
  methods: {
    loopColors() {
      this.loop = setInterval(() => {
				$("body").attr("class", this.colors[this.iteration]);
				this.iteration = this.iteration === 3 ? 0 : this.iteration + 1;
			}, 2000);
    }
  },
  beforeDestroy() {
    clearInterval(this.loop);
  },
  mounted() {
		this.loopColors();
  }
};
</script>
