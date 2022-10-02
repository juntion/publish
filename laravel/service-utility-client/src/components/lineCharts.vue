<template>
    <div>
        <div :id="randomId" style="height: 350px;"></div>
    </div>
</template>
<script>
import echarts from 'echarts'

let Option = {
  title: {
    text: '',
    subtext: ''
  },
  tooltip: {
    trigger: 'axis',
    padding: 10,
    backgroundColor: 'rgba(0, 0, 0, .55)',
    formatter: params => {
      // 获取xAxis data中的数据
      let dataStr = `<div><p style="line-height:18px">${params[0].name}</p>
        <div>
            <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:6px;height:6px;background-color:#FF4A4A;"></span>
            <span>${params[0].seriesName}:</span>
            <span style="color:#FF4A4A;margin-left:4px;">${params[0].data}个</span>
        </div>
        <div>
            <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:7px;height:7px;background-color:#fff;border-radius: 4px;border: 1px solid #AE5010;"></span>
            <span>${params[1].seriesName}:</span>
            <span style="color:#AE5010;margin-left:4px;">${params[1].data}%</span>
        </div>
      </div>`
      return dataStr
    }
  },
  dataZoom: [// 给x轴设置滚动条
    {
      start: 0, // 默认为0
      end: 20, // 默认为100
      type: 'slider',
      show: true,
      xAxisIndex: [0],
      handleSize: 0, // 滑动条的 左右2个滑动条的大小
      height: 10, // 组件高度
      left: '5%', // 左边的距离
      right: '5%', // 右边的距离
      bottom: 26, // 右边的距离
      borderColor: '#fff',
      fillerColor: 'rgba(187, 187, 187, 0.5)',
      borderRadius: 3,
      backgroundColor: '#fff', // 两边未选中的滑动条区域的颜色
      showDataShadow: false, // 是否显示数据阴影 默认auto
      showDetail: false, // 即拖拽时候是否显示详细数值信息 默认true
      realtime: true, // 是否实时更新
      filterMode: 'filter'
    },
    // 下面这个属性是里面拖到
    {
      type: 'inside',
      show: true,
      xAxisIndex: [0],
      start: 0, // 默认为1
      end: 20// 默认为100
    }
  ],
  grid: {
    left: 50, // 距离容器左边界像素
    right: 70 // 距离容器右边界像素
  },
  legend: {
    data: ['延期完成任务数量', '延期完成任务比例'],
    right: 20,
    top: 15,
    itemGap: 20,
    textStyle: {
      color: '#999',
      padding: [3, 0, 0, 0]
    },
    itemHeight: 6,
    itemWidth: 6
  },
  xAxis: [
    {
      type: 'category',
      boundaryGap: true,
      axisTick: {
        show: true, // x轴刻度
        lineStyle: {
          color: '#DFDFDF'
        } // x轴坐标轴颜色
      },
      axisLine: {
        show: false // x轴坐标轴线
      },
      axisLabel: {
        interval: 0,
        textStyle: {
          color: '#999' // x轴字体颜色
        }
      },
      data: ['1', '2', '3', '3', '1']
    }
  ],
  yAxis: [
    {
      type: 'value',
      axisLine: {
        show: false
      },
      axisTick: {
        show: false
      },
      splitLine: {
        lineStyle: {
          //    分割线样式
          color: '#eee'
        }
      },
      min: 0,
      max: 100,
      minInterval: 20,
      axisLabel: {
        formatter: '{value} 个',
        textStyle: {
          color: '#999'
        }
      }
    },
    {
      type: 'value',
      scale: true,
      axisLine: {
        show: false
      },
      axisTick: {
        show: false
      },
      splitLine: {
        show: false,
        lineStyle: {
          //    分割线样式
          color: '#eee'
        }
      },
      min: 0,
      max: 100,
      interval: 20,
      axisLabel: {
        formatter: '{value} %',
        textStyle: {
          color: '#999'
        }
      }

    }
  ],
  series: [
    {
      name: '延期完成任务数量',
      type: 'bar',
      label: {
        show: true,
        position: 'top',
        color: '#FF4A4A'
      },
      itemStyle: {
        // 设置柱状图颜色
        color: new echarts.graphic.LinearGradient(
          0, 0, 0, 1,
          [
            { offset: 0, color: '#FF8585' },
            { offset: 1, color: '#FF4A4A' }

          ]
        )
      },
      barMinWidth: 25,
      barGap: 25,
      barWidth: 25, // 柱图宽度
      yAxisIndex: 0,
      data: [110, 220, 30, 180, 100]
    },
    {
      name: '延期完成任务比例',
      type: 'line',
      yAxisIndex: 1,
      itemStyle: {
        color: '#AE5010'
      },
      data: [10, 82, 25, 54, 90]
    }
  ]
}
export default {
  data () {
    return {
      msg: 'charts',
      myChart: {}
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
    chartType: {
      type: Number,
      default: 1
    },
    chartsData: {
      type: Object
    }
  },
  watch: {
    '$store.state.recount.pageWidth': {
      handler: function (newVal) {
        setTimeout(() => {
          this.myChart.resize()
        }, 500)
      } },
    chartsData (oldVal, newVal) {
      this.drawLine()
    }

  },
  mounted () {
    // this.drawLine()
  },
  methods: {
    drawLine () {
      // 基于准备好的dom，初始化echarts实例
      this.myChart = this.$echarts.init(document.getElementById(this.randomId))
      // 绘制图表
      if (this.chartType === 1) {
        Option.xAxis[0].data = this.chartsData.name
        Option.series[0].data = this.chartsData.overNum
        Option.series[1].data = this.chartsData.overRate
        Option.dataZoom[0].end = 100 / (this.chartsData.name.length / 9)
        if (this.chartsData.name.length < 11) {
          Option.dataZoom[0].show = false
        } else {
          Option.dataZoom[0].show = true
        }

        this.myChart.setOption(Option)
      } else if (this.chartType === 2) {
        let Option2 = JSON.parse(JSON.stringify(Option))
        Option2.legend.data = ['bug处理数量', 'bug比例', 'bug延期处理比例']
        Option2.series[0].name = 'bug处理数量'
        Option2.series[0].label.color = '#378EEF'
        Option2.xAxis[0].data = this.chartsData.name
        Option2.series[0].data = this.chartsData.bugNum
        Option2.series[0].itemStyle.color = new echarts.graphic.LinearGradient(
          0, 0, 0, 1,
          [
            { offset: 0, color: '#68A9F3' },
            { offset: 1, color: '#378EEF' }
          ]
        )
        Option2.dataZoom[0].end = 100 / (this.chartsData.name.length / 9)
        if (this.chartsData.name.length < 11) {
          Option2.dataZoom[0].show = false
        } else {
          Option2.dataZoom[0].show = true
        }
        Option2.tooltip.formatter = params => {
          // 获取xAxis data中的数据
          let dataStr = `<div><p style="line-height:18px">${params[0].name}</p>
            <div>
                <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:6px;height:6px;background-color:#378EEF;"></span>
                <span>${params[0].seriesName}:</span>
                <span style="color:#378EEF;margin-left:4px;">${params[0].data}个</span>
            </div>
            <div>
                <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:7px;height:7px;background-color:#fff;border-radius: 4px;border: 1px solid #0656AA;"></span>
                <span>${params[1].seriesName}:</span>
                <span style="color:#0656AA;margin-left:4px;">${params[1].data}%</span>
            </div>
            <div>
                <span style="display:inline-block;margin-right:2px;vertical-align:1px;width:7px;height:7px;background-color:#fff;border-radius: 4px;border: 1px solid #E82020;"></span>
                <span>${params[2].seriesName}:</span>
                <span style="color:#E82020;margin-left:4px;">${params[2].data}%</span>
            </div>
        </div>`
          return dataStr
        }
        Option2.series[1].name = 'bug比例'
        Option2.series[1].itemStyle.color = '#0656AA'
        Option2.series[1].data = this.chartsData.bugRate
        Option2.series[2] = {
          name: 'bug延期处理比例',
          type: 'line',
          itemStyle: {
            color: '#E82020'
          },
          yAxisIndex: 1,
          data: this.chartsData.overBugRate
        }
        this.myChart.setOption(Option2)
      }
    }
  }
}
</script>
