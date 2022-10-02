<template>
    <div>
        <div :id="randomId" :style="{width: '250px', height: '150px'}" style="margin: 0 auto;text-align: left"></div>
    </div>
</template>
<script>
let pieOption = {
  color: ['#FF4A4A', '#E46AD8', '#378EEF', '#FEBC2E', '#3DCCA6', '#f88d49'],
  tooltip: {
    trigger: 'item',
    backgroundColor: 'rgba(0, 0, 0, .6)',
    padding: 10,
    formatter: params => {
      // 获取xAxis data中的数据
      let dataStr =
      `<div>
          <div>
            <p style="line-height:18px">${params.seriesName}</p>
            <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:6px;height:6px;border-radius: 50%;background-color:${params.color};"></span>
            <span>${params.data.name}类:</span>
            <span style="color:${params.color};margin-left:4px;">${params.data.value}个</span>
          </div>
        </div>`

      return dataStr
    }

  },
  legend: {
    orient: 'vertical',
    right: 0,
    top: 10,
    data: [],
    icon: 'circle',
    itemGap: 10,
    itemHeight: 6,
    itemWidth: 6
  },
  series: [
    {
      name: '任务类型',
      type: 'pie',
      radius: ['65%', '85%'],
      center: ['45%', '50%'],
      data: [ { value: 335, name: 'A类' },
        { value: 310, name: 'B类' },
        { value: 234, name: 'C类' },
        { value: 135, name: 'D类' },
        { value: 1548, name: 'E类' }],
      label: {
        show: false
      },
      labelLine: {
        show: false
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
      msg: 'charts'
    }
  },
  computed: {
    randomId () {
      var Num = ''
      for (var i = 0; i < 6; i++) {
        Num += Math.floor(Math.random() * 10)
      }
      return Num
    }
  },
  props: {
    chartsData: {
      type: Object
    }
  },
  watch: {
    chartsData (oldVal, newVal) {
      this.drawLine()
    }
  },
  mounted () {

  },
  methods: {
    drawLine () {
      // 基于准备好的dom，初始化echarts实例
      let myChart = this.$echarts.init(document.getElementById(this.randomId))
      pieOption.legend.data = this.chartsData.level
      //   pieOption.series[0].data= a
      let array = []
      for (var i = 0; i < this.chartsData.level.length; i++) {
        var obj = {}
        for (var j = 0; j < this.chartsData.levelNum.length; j++) {
          if (i == j) {
            obj.name = this.chartsData.level[i]
            obj.value = this.chartsData.levelNum[j]
            array.push(obj)
          }
        }
      }
      pieOption.series[0].data = array
      // 绘制图表
      myChart.setOption(pieOption)
    }
  }
}
</script>
