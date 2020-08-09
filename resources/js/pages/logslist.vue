<template>
  <div id="logs" class="content">
    <div v-if="toggle.failed || registos && registos.length === 0" class="align-items-center mt-4 justify-content-center d-flex flex-column">
      <h4 class="mt-4">Não existem resultados para mostrar.</h4>
    </div>
    <div v-else>
      <div class="table-responsive">
        <template v-if="toggle.loaded">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="brdc-main">
                  <a tabindex="0" role="button" @click="getLogsBy('page')">
                    Página
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-main">
                  <a tabindex="0" role="button" @click="getLogsBy('user')">
                    Utilizador
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-main">
                    Afetado
                </th>
                <th class="brdc-main">
                  Valor Original
                </th>
                <th class="brdc-main">
                  Valor Alterado
                </th>
                <th class="brdc-main">
                  <a tabindex="0" role="button" @click="getLogsBy('created')">
                    Data de registo
                    <i class="grid-sort"></i>
                  </a>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="registo in registos" :key="registo.id">
                <td>{{ registo.page }}
                </td>
                <td>{{ registo.user_id }}
                </td>
                <td>{{ registo.target_id }}
                </td>
                <td>{{ registo.old_value }}
                </td>
                <td>{{ registo.new_value }}
                </td>
                <td>{{ registo.created_at }}
                </td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
      <pagination v-model="paginacao.update" v-bind:paginas="paginacao" v-on:changepage="setPage($event)"></pagination>
    </div>
  </div>
</template>
<script>
import Pagination from "../components/pagination";

export default {
  components: {
    Pagination
  },
  data() {
    return {
      params: {},
      selecionado: {},
      registos: [],
      paginacao: {
        currentpage: 0,
        lastpage: 0,
        update: 0
      },
      toggle: {
        loaded: false,
        failed: false
      }
    };
  },
  methods: {
    setPage: function(pageNum) {
      this.params.page = pageNum;
      this.loadRegistos();
    },
    getLogsBy: function(order) {
      this.params.order = order;
      this.loadRegistos();
    },
    loadRegistos: function() {
      axios
        .get("/api/stats/registos", { params: this.params })
        .then(({ data }) => {
          this.registos = data.data;
          this.toggle.loaded = true;
          this.paginacao.currentpage = data.current_page;
          this.paginacao.lastpage = data.last_page;
          this.paginacao.update = data.current_page + data.total;
        })
        .catch(() => {
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text: "Por favor tente outra vez, se o erro continuar tente actualizar a página."
          });
        });
    }
  },
  mounted() {
		this.loadRegistos();
  }
};
</script>
