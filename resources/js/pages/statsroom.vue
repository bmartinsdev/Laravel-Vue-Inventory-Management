
<script>
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,
  data: () => ({
    chartdata: {
      labels: [],
     	datasets: [
        {
          backgroundColor: [
            '#e74e3e',
            '#2dcc72',
            '#3697db',
            '#9c59b8',
            '#f1c30e',
            '#e67c24',
            '#2e3f51'
          ],
          data: []
        }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
	}),
	watch: {
		chartData () {
			this.$data._chart.update()
		}
	},
	methods: {
		loadCounts: function() {
      axios
        .get("/api/stats/baixasinventariolocais")
        .then(({ data }) => {
					let totalMostrar = 0;
					data.salas.forEach(sala => {
						this.chartdata.labels.push(sala.nome);
						this.chartdata.datasets[0].data.push(sala.count);
						totalMostrar += sala.count;
					});
					this.chartdata.labels.push("Outras");
					this.chartdata.datasets[0].data.push(data.total-totalMostrar);
    			this.renderChart(this.chartdata, this.options)
        })
        .catch((d) => {
					console.log(d);
        });
    }
	},
  mounted () {
		this.loadCounts();
  }
}
</script>