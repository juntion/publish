<template>
  <div>
    <div :id="charName"
         :style="{width: '350px', height: '200px'}"></div>
  </div>
</template>
<script>

let pieOption = {
  color: ['rgba(255,74,74,1)', 'rgba(61,204,166,1)', 'rgba(254, 190, 42, 1)', 'rgba(52, 143, 240, 1)'],
  title: {
    x: 'center'
  },
  label: {
    formatter: [
      '{a| {d}%}',
      '{a| {c}个}'
    ].join('\n'),
    rich: {
      a: {
        color: 'rgba(102, 102, 102, 1)',
        height: 10
      },
      b: {
        color: 'rgba(102, 102, 102, 1)',
        lineHeight: 10
      }
    }
  },
  tooltip: {
    trigger: 'item',
    formatter: '{a} <br/>{b} : {c} ({d}%)'
  },
  legend: {
    orient: 'vertical',
    right: 10,
    top: 20,
    bottom: 20,
    data: [],
    icon: 'circle',
    itemGap: 34,
    itemHeight: 6,
    itemWidth: 6
  },
  series: [
    {
      name: '',
      type: 'pie',
      radius: ['40%', '60%'],
      center: ['40%', '50%'],
      data: [],
      labelLine: {
        normal: {
          length: 10
        }
      },
      itemStyle: {
        emphasis: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
}
export default {
  data () {
    return {
      msg: 'charts',
      pieOption
    }
  },
  watch: {
    chartsData (oldVal, newVal) {
      this.drawLine()
    }
  },
  props: {
    charName: {
      type: String,
      default: 'myChart'
    },
    chartType: {
      type: Number,
      default: 1
    },
    chartsData: {
      type: Array
    }
  },
  mounted () {
    this.drawLine()
  },
  updated () {

  },
  methods: {
    drawLine () {
      // 基于准备好的dom，初始化echarts实例
      let myChart = this.$echarts.init(document.getElementById(this.charName))
      // 绘制图表
      if (this.chartType === 1) {
        pieOption.series[0].data = this.chartsData.map(item => {
          return { name: item.name, value: item.count }
        })
        this.chartsData.forEach(item => {
          pieOption.legend.data.push(item.name)
        })
        myChart.setOption(pieOption)
      } else if (this.chartType === 2) {
        pieOption.color = ['#FF4A4A', '#F88D49', '#378EEF', '#FEBC2E', '#3DCCA6', '#E46AD8']
        if (this.chartsData) {
          pieOption.series[0].data = this.chartsData.map(item => {
            return { name: item.name, value: item.count }
          })
          pieOption.legend.itemGap = 14
          pieOption.legend.data = []
          this.chartsData.forEach(item => {
            pieOption.legend.data.push(item.name)
          })
          myChart.setOption(pieOption)
        }
      }
    }
  }
}
</script>
<style>
    #myChart br{
        display: none;
    }
     #myChart2 br{
        display: none;
    }
</style>
