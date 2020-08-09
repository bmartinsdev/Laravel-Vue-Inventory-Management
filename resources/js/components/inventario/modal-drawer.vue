<template>
  <div class="grid-modal align-items-center min-vh-100 justify-content-center show" v-show="value" @click.self="close">
    <div class="grid-modal-card">
      <a @click="close" class="grid-modal-close"><i class="grid-fechar"></i></a>
      <h3 class="grid-modal-title mb-4">Mover unidades</h3>
      <form class="grid-modal-form">
        <p>Unidades selecionadas:</p>
        <div class="row mb-3">
          <div v-for="unidade in this.$parent.checkedArmazem" class="col-3 text-center" :key="unidade">
            {{ unidade }}
          </div>
        </div>
        <p>Sala de destino:</p>
        <div class="input-group">
          <select class="custom-select" v-model="targetRoom">
            <option value="" selected disabled hidden>Selecione a sala</option>
            <option v-for="sala in roomList" :value="sala.id" :key="sala.id">{{ sala.nome }}</option>
          </select>
          <label for="search-imob" class="input-group-prepend">
            <i class="grid-arrow-down"></i>
          </label>
        </div>
      </form>
      <div class="grid-modal-footer d-flex justify-content-md-end justify-content-center">
        <button @click="close" class="grid-button m-1 cancel">Cancelar</button>
        <button @click="moveUnits" class="grid-button m-1 bgc-red">Mover</button>
      </div>
    </div>
  </div>
</template>
    
<script>
export default {
  data() {
    return {
      targetRoom: ""
    };
  },
  props: {
    value: {
      required: true
    }
  },
  computed: {
    roomList() {
      return _tail(this.$parent.salas);
    }
  },
  methods: {
    close() {
      this.$emit("input", !this.value);
    },
    moveUnits: function() {
      if (this.targetRoom != "" || this.targetRoom != 1) {
        this.close();
        this.$Progress.start();
        axios
          .put(`api/i/salas/1/unidades/mover`, {
            target: this.targetRoom,
            listaCodigos: this.$parent.checkedArmazem
          })
          .then(d => {
            if (d.data.success.length > 0) {
              let msg = "";
              d.data.success.forEach(unidade => {
                msg += unidade + ", ";
              });
              this.$notify({
                title: "As seguintes unidades foram movidas",
                text: msg.substring(0, msg.length - 2),
                duration: 20000
              });
            }
            if (d.data.failed.length > 0) {
              let msg = "";
              d.data.failed.forEach(unidade => {
                msg += unidade + ", ";
              });
              this.$notify({
                type: "error",
                title: "As seguintes unidades não foram movidas",
                text: msg.substring(0, msg.length - 2),
                duration: 20000
              });
						}
						this.$parent.loadRoomUnits(this.targetRoom);
            this.$parent.checkedArmazem = [];
            this.targetRoom = "";
						this.$Progress.finish();
          })
          .catch(() => {
            this.$notify({
              type: "error",
              title: "Algo falhou",
							text: "Por favor tente outra vez, se o erro continuar tente actualizar a página." 
							});
            this.$Progress.fail();
          });
      }
    }
  }
};
</script>
  