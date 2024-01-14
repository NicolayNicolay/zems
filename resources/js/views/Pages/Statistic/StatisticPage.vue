<template>
  <admin-panel>
    <div v-if="!loading">
      <v-chart class="chart mt-4" :option="option"/>
    </div>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>

<script setup lang="ts">
import {use} from "echarts/core";
import {ref, provide, onMounted} from "vue";
import {CanvasRenderer} from "echarts/renderers";
import {
  LineChart,
  BarChart
} from "echarts/charts";
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  VisualMapComponent,
  GridComponent,
  ToolboxComponent,
  DataZoomComponent,
  CalendarComponent,
  TimelineComponent,
} from "echarts/components";
import VChart, {THEME_KEY} from "vue-echarts";
import axios from "axios";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {config} from "@/config";
import {useBreadcrumbs} from "@/composables/useBreadcrumbs";

use([
  CanvasRenderer,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  LineChart,
  BarChart,
  VisualMapComponent,
  GridComponent,
  ToolboxComponent,
  DataZoomComponent,
  CalendarComponent,
  TimelineComponent,
]);

provide(THEME_KEY, "default");

const {init} = useBreadcrumbs()
const dataAxis = ref([]);
// prettier-ignore
const data = ref([]);
const option = ref({
  title: {
    text: 'Статистика проектов',
    subtext: 'Статиска по выполненным задачам, отображает сколько (часов/минут) было затрачено на выполнение поставленных задач'
  },
  xAxis: {
    data: dataAxis,
    axisLabel: {
      inside: true,
      color: '#fff'
    },
    axisTick: {
      show: false
    },
    axisLine: {
      show: false
    },
    z: 10
  },
  yAxis: {
    axisLine: {
      show: false
    },
    axisTick: {
      show: false
    },
    axisLabel: {
      color: '#999'
    }
  },
  dataZoom: [
    {
      type: 'inside'
    }
  ],
  series: [
    {
      type: 'bar',
      showBackground: true,
      itemStyle: {
        color: '#1324e0'
      },
      emphasis: {
        itemStyle: {
          color: '#1324e0'
        }
      },
      data: data
    }
  ]
})
const loading = ref(true)
const errors = ref(null)
const bread = ref([
  {
    'name': 'Статистика',
    'link': '/admin/statistics',
    'active': false
  }])

init(bread.value, true)

onMounted(() => {
  getData();
})

async function getData() {
  loading.value = true;
  await axios.get(config.api_url + 'statistics/getData')
    .then((response) => {
      data.value = response.data.y;
      dataAxis.value = response.data.x;
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    })
    .finally(() => {
      loading.value = false;
    });
}
</script>
<style scoped>
.chart {
  height: 400px;
}
</style>
