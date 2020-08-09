<template>
  <div id="consumiveis" class="content">
    <modal-stock v-model="toggle.modal" v-bind:consumivel="selecionado" v-on:update="loadConsumiveis()"></modal-stock>
    <a tabindex="0" role="button" id="fixed-search" name="Abrir barra de pesquisa" class="fixed-icon" @click="toggle.search = !toggle.search">
      <i class="grid-search"></i>
    </a>
    <search-bar v-bind:toggle="toggle.search" v-on:filter="updateFilters($event)"></search-bar>
    <loading-logo v-if="!toggle.loaded"></loading-logo>
    <div v-else-if="toggle.failed || consumiveis && consumiveis.length === 0" class="main align-items-center mt-4 justify-content-center d-flex flex-column">
      <h4 class="mt-4">Não existem resultados para mostrar.</h4>
    </div>
    <div class="main" v-else>
      <div class="table-responsive">
        <template v-if="toggle.loaded">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="brdc-yellow">
                  <a tabindex="0" role="button" @click="getConsumiveisBy('nome')">
                    Nome
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-yellow">
                  <a tabindex="0" role="button" @click="getConsumiveisBy('quantidade')">
                    Quantidade
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-yellow">
                  <a tabindex="0" role="button" @click="getConsumiveisBy('categoria')">
                    Categoria
                    <i class="grid-sort"></i>
                  </a>
                </th>
                <th class="brdc-yellow text-right pr-4">
                  Alterar quantidade
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="consumivel in consumiveis" :key="consumivel.id">
                <td>{{ consumivel.nome }}
                </td>
                <td>
                  {{ consumivel.quantidade }}
                  <template v-if="consumivel.cor">
                    <i class="ml-2 grid-dot" :class="'dot-' + consumivel.cor"></i>
                  </template>
                </td>
                <td>{{ consumivel.categoria }}</td>
                <td>
                  <div class="d-flex justify-content-end">
                    <a tabindex="0" role="button" @click="diminuirStock(consumivel)">
                      <i class="grid-menos ftc-default"></i>
                    </a>
                    <input type="number" class="stock mr-2 ml-2 text-center" v-model="consumivel.stock" @change="verificarStock(consumivel)">
                    <a tabindex="0" role="button" @click="aumentarStock(consumivel)">
                      <i class="grid-mais ftc-default"></i>
                    </a>
                    <a tabindex="0" role="button" class="mr-3 ml-4" @click="openModal(consumivel)">
                      <i class="grid-guardar"></i>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
      <pagination v-model="paginacao.update" v-bind:paginas="paginacao" v-on:changepage="setPage($event)" class="yellow-pagination"></pagination>
    </div>
  </div>
</template>
<script>
import SearchBar from "../components/consumiveis/search-bar";
import Pagination from "../components/pagination";
import LoadingLogo from "../components/loading-logo";
import ModalStock from "../components/consumiveis/modal-stock";

export default {
  components: {
    SearchBar,
    LoadingLogo,
    Pagination,
    ModalStock
  },
  data() {
    return {
      params: {},
      selecionado: {},
      consumiveis: [],
      paginacao: {
        currentpage: 0,
        lastpage: 0,
        update: 0
      },
      toggle: {
        search: false,
        loaded: false,
        modal: false,
        failed: false
      }
    };
  },
  methods: {
    openModal: function(consumivel) {
      if (!this.toggle.modal && consumivel.stock !== 0) {
        this.selecionado = consumivel;
        this.toggle.modal = true;
      }
    },
    setPage: function(pageNum) {
      this.params.page = pageNum;
      this.loadConsumiveis();
    },
    updateFilters: function(params) {
      this.params = params;
      this.loadConsumiveis();
    },
    getConsumiveisBy: function(order) {
      this.params.order = order;
      this.loadConsumiveis();
    },
    aumentarStock: function(consumivel) {
      consumivel.stock++;
    },
    diminuirStock: function(consumivel) {
      if (consumivel.stock > -consumivel.quantidade) {
        consumivel.stock--;
      }
    },
    verificarStock: function(consumivel) {
      if (consumivel.stock <= -consumivel.quantidade) {
        consumivel.stock = -consumivel.quantidade;
      }
    },
    loadConsumiveis: function() {
      this.$Progress.start();
      axios
        .get("api/s/consumiveis", { params: this.params })
        .then(({ data }) => {
          this.consumiveis = data.data;
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
    $("body").attr("class", "yellow");
    this.loadConsumiveis();
  }
};
</script>
