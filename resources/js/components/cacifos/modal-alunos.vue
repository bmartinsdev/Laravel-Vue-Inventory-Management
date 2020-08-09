<template>
  <div class="grid-modal align-items-center min-vh-100 justify-content-center show" v-show="value" @click.self="close">
    <div class="grid-modal-card">
      <a @click="close" class="grid-modal-close"><i class="grid-fechar"></i></a>
      <h3 class="grid-modal-title mb-4">Atribuir alunos</h3>
      <small>Apenas alunos já existentes podem ser atribuidos, contate um administrador em caso de dúvida.</small>
      <form class="grid-modal-form">
        <p>Atribuição 1:</p>
        <div class="input-group mb-4 mt-2">
          <template>
            <v-autocomplete v-model="selected.aluno1" :min-len="2" :items="alunos" :get-label="getLabel" :component-item="template" @item-selected="pickAluno1" v-bind:class="{notfound : error.input1}" @change="inputFocused = 1; loadAlunos($event)" :auto-select-one-item="false">
            </v-autocomplete>
          </template>
        </div>
        <p>Atribuição 2:</p>
        <div class="input-group mb-4 mt-2">
          <template>
            <v-autocomplete v-model="selected.aluno2" :min-len="2" :items="alunos" :get-label="getLabel" :component-item="template" @item-selected="pickAluno2" v-bind:class="{notfound : error.input2}" @change="inputFocused = 2; loadAlunos($event)" :auto-select-one-item="false">
            </v-autocomplete>
          </template>
        </div>
      </form>
      <div class="grid-modal-footer d-flex justify-content-md-end justify-content-center">
        <button @click="close" class="grid-button m-1 cancel">Cancelar</button>
        <button @click="atribuirAlunos" class="grid-button m-1 bgc-blue">Guardar</button>
      </div>
    </div>
  </div>
</template>
    
<script>
import autocomplete from "v-autocomplete";
import autoitem from "./auto-item";

export default {
  components: {
    "v-autocomplete": autocomplete,
    autoitem
  },
  data() {
    return {
			alunos: [],
			inputFocused: 0,
			error: {
				input1: false,
				input2: false
			},
      selected: {
        aluno1: null,
        aluno2: null
      },
      template: autoitem
    };
  },
  props: {
    value: {
      required: true
    },
    cacifo: {
      type: Object,
      required: true
    }
  },
  watch: {
    cacifo: function() {
      if (
        this.cacifo &&
        this.cacifo.students &&
        this.cacifo.students.length > 0
      ) {
        this.selected.aluno1 = this.cacifo.students[0];
        if (this.cacifo.students.length > 1) {
          this.selected.aluno2 = this.cacifo.students[1];
        } else {
          this.selected.aluno2 = null;
        }
      } else {
        this.selected.aluno1 = null;
        this.selected.aluno2 = null;
      }
    }
  },
  methods: {
    close() {
			this.$emit("input", !this.value);
			this.alunos = [];
    },
    atribuirAlunos() {
      if (
        this.selected.aluno1 && this.selected.aluno1.codigo &&
        this.selected.aluno2 && this.selected.aluno2.codigo &&
        this.selected.aluno1.codigo === this.selected.aluno2.codigo
      ) {
        this.$notify({
          type: "error",
          title: "Erro validação",
          text: "Não pode atribuir um aluno duas vezes."
        });
        return false;
      }
      axios
        .put("api/c/cacifos/" + this.cacifo.id + "/atribuir", {
          selected: this.selected
        })
        .then(d => {
          this.$notify({
            title: "Cacifo atualizado",
            text: "Atribuição de alunos alterada com sucesso.",
            duration: 10000
          });
          this.$Progress.finish();
          this.$emit("update");
        })
        .catch(d => {
          this.$notify({
            type: "error",
            title: "Algo falhou",
            text: "Por favor verifique todos os campos e tente outra vez."
          });
          this.$Progress.fail();
        });
      this.close();
    },
    getLabel(aluno) {
      if (aluno && aluno.nome) {
        return aluno.nome + " - " + aluno.codigo + " - " + aluno.turma;
      }
    },
    pickAluno1(aluno) {
      this.selected.aluno1 = aluno;
							this.setError(false);
    },
    pickAluno2(aluno) {
      this.selected.aluno2 = aluno;
							this.setError(false);
		},
		setError(errorState){
			if(this.inputFocused !== 0){
				if(this.inputFocused === 1){
				this.error.input1 = errorState
				}else{
				this.error.input2 = errorState
				}
			}
		},
    loadAlunos: _debounce(function(search) { 
      if(search.trim() !== "" && search.trim().length > 1) {
        this.$Progress.start();
        axios
          .get("api/c/alunos", {
            params: { filtro: search, cacifo: this.cacifo.id }
          })
          .then(({ data }) => {
						if(data.length === 0){
							this.setError(true);
						}else{
							this.setError(false);
						}
            this.alunos = data;
            this.$Progress.finish();
          })
          .catch(d => {
						this.setError(true);
            this.$notify({
              type: "error",
              title: "Algo falhou",
              text: "Por favor tente outra vez, se o erro continuar tente actualizar a página."
            });
            this.$Progress.fail();
          });
      }
    }, 1000),
  }
};
</script>
  