<template>
  <div id="searchbar" :class="{ show: toggle }" class="row">
    <div class="col">
      <div class="input-group mb-2">
        <input type="text" class="form-control" id="search-nome" v-model="params.nome" placeholder="Número" @input="emitFilters"/>
        <label for="search-nome" class="input-group-prepend">
          <i class="grid-search"></i>
        </label>
      </div>
    </div>
    <div class="col">
      <div class="input-group mb-2">
        <input type="text" class="form-control" id="search-aluno" v-model="params.aluno" placeholder="Formando / Turma" @input="emitFilters"/>
        <label for="search-aluno" class="input-group-prepend">
          <i class="grid-search"></i>
        </label>
      </div>
    </div>
    <div class="col">
      <div class="input-group mb-2">
        <select v-model="params.topologia" id="search-topologia" class="custom-select" @change="emitFilters">
          <option value="0" selected>Topologia</option>
          <template v-if="topologias.length">
            <option v-for="topologia in topologias" :value="topologia.id" :key="topologia.id">{{ topologia.nome }}</option>
          </template>
        </select>
        <label for="search-topologia" class="input-group-prepend">
          <i class="grid-arrow-down"></i>
        </label>
      </div>
    </div>
    <div class="col">
      <div class="input-group mb-2">
        <select v-model="params.local" id="search-local" class="custom-select" @change="emitFilters">
          <option value="0" selected>Local</option>
          <template v-if="locais.length">
            <option v-for="local in locais" :value="local.id" :key="local.id">{{ local.nome }}</option>
          </template>
        </select>
        <label for="search-local" class="input-group-prepend">
          <i class="grid-arrow-down"></i>
        </label>
      </div>
    </div>
    <div class="col">
      <div class="input-group mb-2">
        <select v-model="params.estado" id="search-estado" class="custom-select" @change="emitFilters">
          <option value="0" selected>Estado</option>
          <template v-if="estados.length">
            <option v-for="estado in estados" :value="estado.id" :key="estado.id">{{ estado.nome }}</option>
          </template>
        </select>
        <label for="search-estado" class="input-group-prepend">
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
				aluno: "",
				local: 0,
				topologia: 0,
				estado: 0,
			},
      estados: [],
      locais: [],
      topologias: []
    };
  },
  props: {
    toggle: {
      required: true
    }
	},
  methods: {
    loadLocais: function() {
      axios
        .get("api/c/locais")
        .then(({ data }) => {
          this.locais = data;
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
    loadTopologias: function() {
      axios
        .get("api/c/topologias")
        .then(({ data }) => {
          this.topologias = data;
        })
        .catch(() => {
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text:
              "Por favor tente outra vez, se o erro continuar tente actualizar a página."
          });
        });
    },
    loadEstados: function() {
      axios
        .get("api/c/estados")
        .then(({ data }) => {
          this.estados = data;
        })
        .catch(() => {
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
			this.loadLocais();
			this.loadTopologias();
			this.loadEstados();
    }, 1000),
	},
	computed: {
		paramscomputed() {
			let computed = {};
			if(this.params.nome.trim() !== "" && this.params.nome.length > 2){
				computed.nome = this.params.nome;
			}
			if(this.params.aluno.trim() !== "" && this.params.aluno.length > 2){
				computed.aluno = this.params.aluno;
			}
			if(this.params.local != 0){
				computed.local = this.params.local;
			}
			if(this.params.topologia != 0){
				computed.topologia = this.params.topologia;
			}
			if(this.params.estado != 0){
				computed.estado = this.params.estado;
			}
			return computed;
		}
	},
  mounted() {
		this.loadAll();
  }
};
</script>
  