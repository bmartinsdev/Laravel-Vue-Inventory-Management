<template>
  <div v-if="paginas.currentpage > 0 && paginas.lastpage != 1" class="d-flex justify-content-end">
    <ul class="pagination" role="navigation">
      <li v-if="paginas.currentpage > 1"  class="page-item"><a class="page-link" tab-index="0" @click="changePage(1)">1</a></li>
      <li v-if="paginas.currentpage > 3" class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
      <li v-if="paginas.currentpage > 2" class="page-item"><a class="page-link" tab-index="0" @click="changePage(paginas.currentpage-1)">{{ paginas.currentpage-1 }}</a></li>
      <li class="page-item active" aria-current="page"><span class="page-link">{{paginas.currentpage}}</span></li>
      <li v-if="paginas.currentpage < paginas.lastpage -1" class="page-item"><a class="page-link" tab-index="0" @click="changePage(paginas.currentpage+1)">{{paginas.currentpage+1}}</a></li>
      <li v-if="paginas.currentpage < paginas.lastpage -2" class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
      <li v-if="paginas.currentpage != paginas.lastpage" class="page-item"><a class="page-link" tab-index="0" @click="changePage(paginas.lastpage)">{{ paginas.lastpage }}</a></li>
    </ul>
  </div>
</template>
    
<script>
export default {
  props: {
    paginas: {
      type: Object,
      required: true
    }
  },
  methods: {
    changePage(pageNumber) {
      this.$emit("changepage", pageNumber);
    },
	}
};
</script>
  