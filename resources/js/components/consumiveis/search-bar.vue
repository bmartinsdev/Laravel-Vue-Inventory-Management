<template>
  <div id="searchbar" :class="{ show: toggle }" class="row">
    <div class="col">
      <div class="input-group mb-2">
        <input type="text" class="form-control" id="search-nome" v-model="params.nome" placeholder="Nome" @input="emitFilters"/>
        <label for="search-nome" class="input-group-prepend">
          <i class="grid-search"></i>
        </label>
      </div>
    </div>
    <div class="col">
      <div class="input-group mb-2">
        <select v-model="params.categoria" id="search-categoria" class="custom-select" @change="emitFilters">
          <option value="0" selected>Categoria</option>
          <template v-if="categorias.length">
            <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">{{ categoria.nome }}</option>
          </template>
        </select>
        <label for="search-topologia" class="input-group-prepend">
          <i class="grid-arrow-down"></i>
        </label>
      </div>
    </div>
  </div>
</template>
    
<script>
export default {
  data() {
    return {
			params: {
				nome: "",
				categoria: 0,
			},
      categorias: []
    };
  },
  props: {
    toggle: {
      required: true
    }
	},
  methods: {
    loadCategorias: function() {
      axios
        .get("api/s/categorias")
        .then(({ data }) => {
          this.categorias = data;
        })
        .catch(() => {
          this.$Progress.fail();
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text:
              "Por favor tente outra vez, se o erro continuar tente actualizar a página."
          });
        });
    },
    emitFilters: _debounce(function() {
      this.$emit("filter", this.paramscomputed);
    }, 1000),
    loadAll: _debounce(function() {
			this.loadCategorias();
    }, 1000),
	},
	computed: {
		paramscomputed() {
			let computed = {};
			if(this.params.nome.trim() !== "" && this.params.nome.length > 2){
				computed.nome = this.params.nome;
			}
			if(this.params.categoria != 0){
				computed.categoria = this.params.categoria;
			}
			return computed;
		}
	},
  mounted() {
		this.loadAll();
  }
};
</script>
  