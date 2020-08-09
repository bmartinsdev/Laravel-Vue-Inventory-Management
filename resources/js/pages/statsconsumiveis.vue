
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  data: () => ({
		meses: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
    chartdata: {
      labels: [],
     	datasets: [
        {
					backgroundColor: ["#cd9f6350"],
          data: []
        }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
			legend: {display:false}
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
        .get("/api/stats/baixasconsumiveis")
        .then(({ data }) => {
					data.forEach(cons => {
						this.chartdata.labels.push(this.meses[cons.month-1]);
						this.chartdata.datasets[0].data.push(cons.count);
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