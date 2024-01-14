<template>
  <admin-panel>
    <template v-if="!loading">
      <flash-message type="success" class="mb-2"></flash-message>
      <h1 class="bd-title"> {{ data.name }} </h1>
      <div class="row">
        <div class="col-6 col-lg-2">
          <button class="btn btn-primary btn-sm w-100 fw-bolder" @click.prevent="createTask" title="Добавить">
            <i class="fas fa-plus me-1"></i>
            Добавить
          </button>
        </div>
      </div>
      <div class="mt-4 mb-4">
        <div class="row">
          <div class="col mx-2 px-2 py-3 bg-light border rounded">
            <h6>Новые 💡</h6>
            <draggable
              class="draggable-list"
              :list="tasks.ideas"
              group="tasks"
              @change="moved"
              itemKey="name"
            >
              <template #item="{ element, index }">
                <div class="bg-white mt-3 p-3 shadow border rounded" @click.prevent="editTask(element)">
                  <h6>{{ element.name }}</h6>
                  <div class="text-muted" v-html="element.short_description"></div>
                  <div v-if="element.make_user_data" class="mt-2">
                    Исполнитель: {{ element.make_user_data.name }}
                  </div>
                </div>
              </template>
            </draggable>
          </div>
          <div class="col mx-2 px-2 py-3 bg-light border rounded">
            <h6>Выполняются ✍</h6>
            <draggable
              class="draggable-list"
              :list="tasks.todos"
              group="tasks"
              @change="moved"
              itemKey="name"
            >
              <template #item="{ element, index }">
                <div class="bg-white mt-3 p-3 shadow border rounded" @click.prevent="editTask(element)">
                  <h6>{{ element.name }}</h6>
                  <div class="text-muted" v-html="element.short_description"></div>
                  <div v-if="element.make_user_data" class="mt-2">
                    Исполнитель: {{ element.make_user_data.name }}
                  </div>
                </div>
              </template>
            </draggable>
          </div>
          <div class="col mx-2 px-2 py-3 bg-light border rounded">
            <h6>На исправлении 🗓</h6>
            <draggable
              class="draggable-list"
              :list="tasks.inProgress"
              group="tasks"
              @change="moved"
              itemKey="name"
            >
              <template #item="{ element, index }">
                <div class="bg-white mt-3 p-3 shadow border rounded" @click.prevent="editTask(element)">
                  <h6>{{ element.name }}</h6>
                  <div class="text-muted" v-html="element.short_description"></div>
                  <div v-if="element.make_user_data" class="mt-2">
                    Исполнитель: {{ element.make_user_data.name }}
                  </div>
                </div>
              </template>
            </draggable>
          </div>
          <div class="col mx-2 px-2 py-3 bg-light border rounded">
            <h6>Сделаны ✅</h6>
            <draggable
              class="draggable-list"
              :list="tasks.completed"
              group="tasks"
              @change="moved"
              itemKey="name"
            >
              <template #item="{ element, index }">
                <div class="bg-white mt-3 p-3 shadow border rounded p-2" @click.prevent="editTask(element)">
                  <h6>{{ element.name }}</h6>
                  <div class="text-muted" v-html="element.short_description"></div>
                  <div v-if="element.make_user_data" class="mt-2">
                    Исполнитель: {{ element.make_user_data.name }}
                  </div>
                </div>
              </template>
            </draggable>
          </div>
        </div>
      </div>
    </template>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>
<script lang="ts" setup>
import draggable from "vuedraggable";
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {onMounted, ref} from "vue"
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import axios from "axios";
import {config} from "@/config";
import {useRoute, useRouter} from 'vue-router';
import FlashMessage from "@/components/System/FlashMessage.vue";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import TaskModal from "@/components/Modals/TaskModal.vue";
import {useModal} from "@/composables/useModal";

const {init} = useBreadcrumbs()
const modal = useModal()
const token = ref(null)
const loading = ref(true)
const objectId = ref(0)
const bread = ref([
  {
    'name': 'Проекты',
    'link': '/admin',
    'active': true
  },
  {
    'name': 'Задачи проекта',
    'link': '#',
    'active': false
  }])
const data = ref([])
const tasks = ref({
  'ideas': [],
  'todos': [],
  'inProgress': [],
  'completed': [],
})
const route = useRoute()
const router = useRouter()
const errors = ref(null)

init(bread.value, true)

onMounted(() => {
  let tokenPage = document.head.querySelector('meta[name="csrf-token"]');
  if (tokenPage) {
    token.value = ref(tokenPage.content)
  }
  getData();
})

async function getData() {
  loading.value = true;
  if (route.params && route.params.id) {
    objectId.value = Number(route.params.id);
  }
  await axios.get(config.api_url + 'projects/get_tasks' + (objectId.value ? '/' + objectId.value : ''))
    .then((response) => {
      data.value = response.data;
      tasks.value = response.data.tasks;
      bread.value[1].name = data.value.name;
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

function createTask() {
  modal.open({
    component: TaskModal,
    modelValue: {
      project_id: objectId.value,
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function editTask(el: any) {
  modal.open({
    component: TaskModal,
    modelValue: {
      project_id: objectId.value,
      element: el,
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function moved(evt: any) {
  if (evt.added) {
    const find = evt.added.element.id;
    let needKey = '';
    for (let key of Object.keys(tasks.value)) {
      if (tasks.value[key as keyof object].find((x: { id: string; }) => x.id === find)) {
        needKey = key;
      }
    }
    if (needKey) {
      changeState(find, needKey);
    }
  }
}

function changeState(id: number, state: string) {
  axios.post(config.api_url + 'tasks/changeState', {'id': id, 'state': state})
}
</script>
<style scoped>
h6 {
  font-weight: 700;
}

.col {
  height: 90vh;
  overflow: auto;
}

.draggable-list {
  min-height: 10vh;
}

.draggable-list > div {
  cursor: pointer;
}
</style>
