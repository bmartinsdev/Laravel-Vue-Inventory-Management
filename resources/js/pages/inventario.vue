<template>
  <div id="inventario" class="content">
    <drawer-modal v-model="toggle.modal"></drawer-modal>
    <a tabindex="0" role="button" name="Abrir armazém" id="fixed-armazem" class="fixed-icon fixed-link" @click="toggleDrawer()">
      <i class="grid-box"></i>
    </a>
    <a tabindex="0" role="button" id="fixed-search" name="Abrir barra de pesquisa" class="fixed-icon" @click="toggle.search = !toggle.search">
      <i class="grid-search"></i>
    </a>
    <div id="searchbar" :class="{ show: toggle.search }" class="row">
      <div class="col">
        <div class="input-group mb-2">
          <input type="text" class="form-control" id="search-sala" v-model="search.sala" placeholder="Sala" />
          <label for="search-sala" class="input-group-prepend">
            <i class="grid-search"></i>
          </label>
        </div>
      </div>
      <div class="col">
        <div class="input-group mb-2">
          <input type="text" id="search-inventario" class="form-control" v-model="search.inv" placeholder="Inventário" @input="updateUnits" />
          <label for="search-inventario" class="input-group-prepend">
            <i class="grid-search"></i>
          </label>
        </div>
      </div>
      <div class="col">
        <div class="input-group mb-2">
          <select v-model="search.imob" id="search-imob" class="custom-select" @change="updateUnits">
            <option value="0" selected>Tipo de Imobilizado</option>
            <option value="1">OBS</option>
            <option value="2">Investimento</option>
          </select>
          <label for="search-imob" class="input-group-prepend">
            <i class="grid-arrow-down"></i>
          </label>
        </div>
      </div>
    </div>
		<loading-logo v-if="!toggle.loaded"></loading-logo>
		<div v-else-if="toggle.failed || salas && salas.length === 1" class="main align-items-center mt-4 justify-content-center d-flex flex-column">
			<h4 class="mt-4">Não existem resultados para mostrar.</h4>
		</div>
    <div class="main" v-else>
      <perfect-scrollbar id="drawerToggle" :class="{ show: toggle.drawer}">
        <div class="targetmove">
          <button class="grid-button" @click="openModal" v-bind:class="{disabled: toggle.moveBtn}">
            <template v-if="checkedArmazem.length === 0"><i class="grid-box"></i> Mover Todos</template>
            <template v-else><i class="grid-box"></i> Mover Selecionados</template>
          </button>
        </div>
        <draggable class="list-group sala armazem" :list="salas[0].inv" :key="salas[0].id" group="inventory" v-bind="dragOptions" @start="toggle.drag = true; toggle.drawer = false" @end="toggle.drag = false" @add="checkMove" handle=".handle">
          <transition-group :id="'room-' + salas[0].id" type="transition" :name="!toggle.drag ? 'flip-list' : null">
            <div :id="'codigo-' + item.codigo" v-for="item in roomFill[0].inv"  :key="item.codigo" class="card brdc-main">
              <div class="cardheader ft-4">
                <h4 class="p-2 handle title">
                  <i class="grid-move"></i>
                  {{item.nome}}
                </h4>
                <h4 class="p-2 code">{{ item.codigo }}</h4>
              </div>
              <div class="cardcontent ft-5">
                <div class="detalhes p-2">
                  <template v-if="item.altura">
                    <span class="ftc-default">A</span> {{ item.altura }}<small>{{ item.unidade_medida }}</small>
                  </template>
                  <template v-if="item.largura">
                    <span class="ftc-default">L</span> {{ item.largura }}<small>{{ item.unidade_medida }}</small>
                  </template>
                  <template v-if="item.comprimento">
                    <span class="ftc-default">C</span> {{ item.comprimento }}<small>{{ item.unidade_medida }}</small>
                  </template>
                  <span v-if="item.custo == 1" class="ftc-default">OBS</span>
                  <span v-else-if="item.custo == 2" class="ftc-default">INV</span>
                </div>
                <label class="gridselectcontainer">
                  <input type="checkbox" checked="checked" :id="item.codigo" :value="item.codigo" name="product" v-model="checkedArmazem" />
                  <span class="gridselect"></span>
                </label>
              </div>
            </div>
          </transition-group>
        </draggable>
      </perfect-scrollbar>
      <masonry :cols="{default: 3, 992: 2, 576: 1}" :gutter="{default: '20px'}">
        <div v-for="sala in roomFilter" :key="sala.id">
          <div class="cardholder mb-3" :class="{ 'toggled': sala.toggle }">
            <h2 class="p-2 roomtoggle mb-2">
              <a tabindex="0" role="button" @click="toggleRoom(sala)">
                <span>{{ sala.nome }}</span>
                <i class="grid-arrow-down ft-4"></i>
              </a>
            </h2>
            <draggable :list="sala.inv" :key="sala.id" class="list-group sala" group="inventory" v-bind="dragOptions" @start="toggle.drag = true" @end="toggle.drag = false" @add="checkMove" handle=".handle">
              <transition-group :id="'room-' + sala.id" type="transition" :name="!toggle.drag ? 'flip-list' : null">
                <div class="card brdc-main" :id="'codigo-' + item.codigo" v-for="item in sala.inv" :key="item.codigo">
                  <div class="cardheader ft-4">
                    <h4 class="p-2 handle title">
                      <i class="grid-move"></i>
                      {{item.nome}}
                    </h4>
                    <h4 class="p-2 code">{{ item.codigo }}</h4>
                  </div>
                  <div class="cardcontent ft-5">
                    <div class="detalhes p-2">
                      <template v-if="item.altura">
                        <span class="ftc-default">A</span> {{ item.altura }}<small>{{ item.unidade_medida }}</small>
                      </template>
                      <template v-if="item.largura">
                        <span class="ftc-default">L</span> {{ item.largura }}<small>{{ item.unidade_medida }}</small>
                      </template>
                      <template v-if="item.comprimento">
                        <span class="ftc-default">C</span> {{ item.comprimento }}<small>{{ item.unidade_medida }}</small>
                      </template>
                      <span v-if="item.custo == 1" class="ftc-default">OBS</span>
                      <span v-else-if="item.custo == 2" class="ftc-default">INV</span>
                    </div>
                    <div class="p-2">
                      <a tabindex="0" role="button" @click="manualMove(item, 1)">
                        <i class="grid-box ft-4"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </transition-group>
            </draggable>
          </div>
        </div>
      </masonry>
    </div>
  </div>
</template>
<script>
import draggable from "vuedraggable";
import PerfectScrollbar from "vue2-perfect-scrollbar";
import VueMasonry from "vue-masonry-css";
import DrawerModal from "../components/inventario/modal-drawer";
import LoadingLogo from "../components/loading-logo";

Vue.use(VueMasonry);
Vue.use(PerfectScrollbar);

export default {
  components: {
    draggable,
    LoadingLogo,
    DrawerModal
  },
  data() {
    return {
      toggle: {
        drawer: false,
        search: false,
        drag: false,
				modal: false,
				failed: false,
				loaded: false,
				moveBtn: false
      },
      search: {
        sala: "",
        inv: "",
        imob: 0
      },
      checkedArmazem: [],
      tSala: 1,
      inv: [],
      salas: [
        {
          id: 1,
          inv: []
        }
      ]
    };
  },
  computed: {
    dragOptions() {
      return {
        animation: 300,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      };
    },
    roomFilter() {
      if (this.search.sala) {
        let myregex = this.search.sala.replace(/ /g, "|");
        let regex = new RegExp(
          myregex[myregex.length - 1] === "|"
            ? myregex.substring(0, myregex.length - 1)
            : myregex,
          "i"
        );
        return this.roomFill.filter(s => {
          return s.id === 1 ? false : regex.test(s.nome);
        });
      } else {
        return _tail(this.roomFill);
      }
    },
    roomFill() {
      this.salas.forEach(sala => {
        sala.inv = this.inv.filter(i => {
          return i.room_id === sala.id;
        });
      });
			this.updateMoveBtn();
      return this.salas;
    }
  },
  methods: {
		updateMoveBtn: function(){
			if(this.salas[0].inv){
				this.toggle.moveBtn = this.salas[0].inv.length == 0;
			}else{
				this.toggle.moveBtn = true;
			}
		},
    openModal: function() {
      if(this.salas[0].inv && this.salas[0].inv.length > 0) {
        if(this.checkedArmazem.length != 0) {
          this.checkedArmazem = this.checkedArmazem.filter(check => {
            return this.inv.find(i => i.codigo == check).room_id === 1;
          });
        } else {
          this.salas[0].inv.forEach(i => {
            return this.checkedArmazem.push(i.codigo);
          });
        }
        this.toggle.drawer = false;
        this.toggle.modal = true;
      }
    },
    toggleRoom: function(sala) {
      if (!sala.toggle) {
        sala.toggle = true;
        this.loadRoomUnits(sala.id);
      } else {
        sala.toggle = false;
      }
    },
    toggleDrawer: function() {
      if (!this.toggle.drawer) {
        this.toggle.drawer = true;
        this.loadRoomUnits(1);
      } else {
        this.toggle.drawer = false;
      }
    },
    toggleRooms: function() {
      this.salas.forEach(sala => {
        sala.toggle = true;
      });
    },
    checkMove: function(evt) {
      let original = Number(evt.from.id.replace("room-", ""));
      let sala = Number(evt.target.id.replace("room-", ""));
      let codigo = evt.item.id.replace("codigo-", "");
      this.moveUnit(codigo, sala, original);
    },
    manualMove: function(item, sala) {
      let origem = item.room_id;
      this.moveUnit(item.codigo, sala, origem);
    },
    updateUnits: _debounce(function() {
      if (this.search.inv.trim().length > 2) {
        this.loadUnits();
        this.toggleRooms();
      }
    }, 1000),
    moveUnit: function(codigo, sala, original) {
      this.inv.find(i => i.codigo === codigo).room_id = sala;
      axios
        .put(`api/i/salas/${original}/unidades/${codigo}/mover`, { target: sala })
        .then(d => {
          this.$notify({
            title: "Unidade movida com sucesso",
            text: "A unidade " + d.data.codigo + " foi movida com sucesso."
					});
					this.$forceUpdate();
        })
        .catch(d => {
          this.inv.find(i => i.codigo === codigo).room_id = d.response.data.room_id;
          this.$notify({
            type: "error",
            title: "Operação falhou",
            text: "A unidade " + d.response.data.codigo + " foi movida para a sala correta."
          });
        });
    },
    loadRooms: function() {
      this.$Progress.start();
      axios
        .get("api/i/salas")
        .then(({ data }) => {
          this.salas = data;
					this.$Progress.finish();
					this.toggle.loaded = true;
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
    },
    loadUnits: _throttle(function() {
      this.$Progress.start();
      axios
        .get("api/i/unidades", {
          params: {
            search: this.search.inv,
            custo: this.search.imob
          }
        })
        .then(({ data }) => {
          this.inv = data;
          this.$Progress.finish();
					this.$forceUpdate();
        })
        .catch(() => {
          this.$Progress.fail();
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text: "Por favor tente outra vez, se o erro continuar tente actualizar a página."
          });
        });
    }, 500),
    loadRoomUnits: function(room) {
      this.$Progress.start();
      axios
        .get("api/i/salas/" + room + "/unidades", {
          params: {
            search: this.search.inv,
            custo: this.search.imob
          }
        })
        .then(({ data }) => {
          this.inv = _unionBy(data, this.inv, "codigo");
					this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text: "Por favor tente outra vez, se o erro continuar tente actualizar a página."
          });
        });
    }
  },
  mounted() {
		$("body").attr("class", "red");
		this.loadRooms();
  }
};
</script>
