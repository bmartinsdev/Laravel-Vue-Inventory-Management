<template>
  <div id="cacifos" class="content">
    <modal-alunos v-model="toggle.modal" v-bind:cacifo="selecionado" v-on:update="loadCacifos()"></modal-alunos>
    <a tabindex="0" role="button" id="fixed-search" name="Abrir barra de pesquisa" class="fixed-icon" @click="toggle.search = !toggle.search">
      <i class="grid-search"></i>
    </a>
    <search-bar v-bind:toggle="toggle.search" v-on:filter="updateFilters($event)"></search-bar>
		<loading-logo v-if="!toggle.loaded"></loading-logo>
		<div v-else-if="toggle.failed || cacifos && cacifos.length === 0" class="main align-items-center mt-4 justify-content-center d-flex flex-column">
			<h4 class="mt-4">Não existem resultados para mostrar.</h4>
		</div>
    <div class="main" v-else>
      <div class="table-responsive">
        <template v-if="toggle.loaded">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="brdc-blue">
                  <a tabindex="0" role="button" @click="getCacifosBy('nome')">
                    Número
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-blue">
                  <a tabindex="0" role="button" @click="getCacifosBy('estado')">
                    Estado
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-blue">
                  <a tabindex="0" role="button">
                    Atribuição 1
                  </a>
                </th>
                <th class="brdc-blue">
                  <a tabindex="0" role="button">
                    Atribuição 2
                  </a>
                </th>
                <th class="brdc-blue">
                  <a tabindex="0" role="button" @click="getCacifosBy('local')">
                    Local
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-blue">
                  <a tabindex="0" role="button" @click="getCacifosBy('topologia')">
                    Topologia
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-blue">
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cacifo in cacifos" :key="cacifo.id">
                <td>{{ cacifo.nome }}</td>
                <td>{{ cacifo.estado }}</td>
                <td>
									<template v-if="cacifo.students.length > 0">
										 <div>{{cacifo.students[0].nome}}</div>
										 <small class="detalhes-aluno">{{cacifo.students[0].codigo}} - {{cacifo.students[0].turma}}</small>
									</template>
								</td>
                <td>
									<template v-if="cacifo.students.length > 1">
										 <div>{{cacifo.students[1].nome}}</div>
										 <small class="detalhes-aluno">{{cacifo.students[1].codigo}} - {{cacifo.students[1].turma}}</small>
									</template>
								</td>
                <td>{{ cacifo.local }}</td>
                <td>{{ cacifo.topologia }}</td>
                <td class="text-center">
                  <a tabindex="0" role="button" @click="openModal(cacifo)">
                    <i class="grid-editar"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
			<pagination v-model="paginacao.update" v-bind:paginas="paginacao" v-on:changepage="setPage($event)" class="blue-pagination"></pagination>
    </div>
  </div>
</template>
<script>
import ModalAlunos from "../components/cacifos/modal-alunos";
import SearchBar from "../components/cacifos/search-bar";
import Pagination from "../components/pagination";
import LoadingLogo from "../components/loading-logo";

export default {
  components: {
		ModalAlunos,
		SearchBar,
    LoadingLogo,
		Pagination
  },
  data() {
    return {
			params: {},
			selecionado: {},
      cacifos: [],
			paginacao: {
				currentpage: 0,
				lastpage: 0,
				update: 0
			},
      toggle: {
        search: false,
        modal: false,
				loaded: false,
				failed: false
      }
    };
  },
  methods: {
    openModal: function(cacifo) {
      if (!this.toggle.modal) {
				this.selecionado = cacifo;
				this.toggle.modal = true;
      }
    },
		setPage: function(pageNum) {
			this.params.page = pageNum;
			this.loadCacifos();
		},
		updateFilters: function(params) {
			this.params = params;
			this.loadCacifos();
		},
		getCacifosBy: function(order){
			this.params.order = order;
			this.loadCacifos();
		},
    loadCacifos: function() {
			this.$Progress.start();
      axios
        .get("api/c/cacifos", {params: this.params})
        .then(({ data }) => {
          this.cacifos = data.data;
          this.toggle.loaded = true;
					this.$Progress.finish();
					this.paginacao.currentpage = data.current_page;
					this.paginacao.lastpage = data.last_page;
					this.paginacao.update = data.current_page + data.total;
        })
        .catch(() => {
          this.$Progress.fail();
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text: "Por favor tente outra vez, se o erro continuar tente actualizar a página."
					});
					this.toggle.failed = true;
        });
    }
	},
  mounted() {
    $("body").attr("class", "blue");
    this.loadCacifos();
  }
};
</script>
