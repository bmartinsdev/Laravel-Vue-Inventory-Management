<template>
  <div class="grid-modal align-items-center min-vh-100 justify-content-center show" v-show="value" @click.self="close">
    <div class="grid-modal-card">
      <a @click="close" class="grid-modal-close"><i class="grid-fechar"></i></a>
      <h3 class="grid-modal-title mb-4">Alterar quantidade</h3>
      <p>Tem a certeza que deseja alterar a quantidade de {{ consumivel.nome }}?</p>
			<h2 class="d-flex justify-content-center m-4">
				<span>{{ consumivel.quantidade }}</span>
				<i class="grid-seta ml-4 mr-4"></i>
				<span>{{ quantidadeFinal }}</span>
			</h2>
      <div class="grid-modal-footer d-flex justify-content-md-end justify-content-center">
        <button @click="close" class="grid-button m-1 cancel">Cancelar</button>
        <button @click="alterarConsumivel" class="grid-button m-1 bgc-yellow">Guardar</button>
      </div>
    </div>
  </div>
</template>
    
<script>
export default {
  data() {
    return {
			quantidadeFinal: 0,
    };
  },
  props: {
    value: {
      required: true
    },
    consumivel: {
      type: Object,
      required: true
    }
	},
	watch: {
    value: function() {
			this.quantidadeFinal = Number(this.consumivel.quantidade) + Number(this.consumivel.stock);
    }
  },
  methods: {
    close() {
			this.$emit("input", !this.value);
			this.quantidadeFinal = 0;
    },
    alterarConsumivel() {
      axios
        .put("api/s/consumiveis/" + this.consumivel.id + "/update", { consumivel: this.consumivel })
        .then(d => {
          this.$notify({
            title: d.data.nome + " atualizado",
            text: "Quantidade alterada para " + d.data.quantidade,
            duration: 10000
          });
          this.$Progress.finish();
          this.$emit("update");
        })
        .catch(d => {
          this.$notify({
            type: "error",
            title: "Verificação de integridade falhou",
            text: "Por favor verifique o stock indicado e tente outra vez."
          });
          this.$Progress.fail();
        });
      this.close();
    }
  }
};
</script>
  