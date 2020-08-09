<template>
  <div>
		<template v-if="item && item.nome">
			{{item.nome}}	<small class="detalhes-aluno">{{item.codigo}} - {{item.turma}}</small>
		</template>
		<template v-else>Por favor pesquise por nome, código ou turma do aluno a atribuir.</template>
  </div>
</template>
    
<script>
export default {
  props: {
    item: { required: true },
    searchText: { required: true }
  }
}
</script>
  