
<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
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
            '#e67c24'
          ],
          data: []
        }]
    },
    options: {
      responsive: true,
			maintainAspectRatio: false,
			legend: {display:false}
    }
	}),
	methods: {
		loadCounts: function() {
      axios
        .get("/api/stats/baixasinventario")
        .then(({ data }) => {
					data.forEach(inv => {
						this.chartdata.labels.push(inv.nome);
						this.chartdata.datasets[0].data.push(inv.count);
					});
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