<template>
  <admin-panel>
    <flash-message type="success" class="mb-2"></flash-message>
    <h1 class="bd-title">Проекты</h1>
    <template v-if="!loading">
      <div class="row">
        <div class="col-6 col-lg-2">
          <router-link class="btn btn-primary btn-sm w-100 fw-bolder" :to="{name: 'CreateProjectForm'}" title="Добавить">
            <i class="fas fa-plus me-1"></i>
            Добавить
          </router-link>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-8">
          <div class="parts-wrapper">
            <table class="table table-parts table-sm table-bordered table-hover">
              <thead class="table-light">
              <tr>
                <th scope="col" width="3%">ID</th>
                <th scope="col" width="50%">Название</th>
                <th scope="col" width="7%">Задач</th>
                <th scope="col" width="20%">Дата создания</th>
                <th scope="col" width="15%">Создал</th>
                <th scope="col" width="5%">Действия</th>
              </tr>
              </thead>
              <tbody class="parts table-group-divider">
              <template v-if="data.length > 0">
                <tr v-for="(object,index) in data" :key="index">
                  <td>{{ object.id }}</td>
                  <td>
                    <router-link :to="{name: 'TasksProject', params: {id: object.id}}" class="text-decoration-none text-black fw-bolder">{{ object.name }}</router-link>
                  </td>
                  <td>{{ object.tasks_count }}</td>
                  <td>{{ object.created_at }}</td>
                  <td>{{ object.user_data.name }}</td>
                  <td class="text-center">
                    <router-link class="me-2" :to="{name: 'EditProjectForm', params: {id: object.id}}" title="Редактировть">
                      <edit-icon class="move-icon"></edit-icon>
                    </router-link>
                    <a href="#" title="Удалить" @click.prevent="removeItemModal(object.id)">
                      <delete-icon class="move-icon"></delete-icon>
                    </a>
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr>
                  <td colspan="6" class="text-center">
                    Проекты не найдены
                  </td>
                </tr>
              </template>
              </tbody>
            </table>
            <pagination-component :paginated="data" :current-page="page" @updateList="getData"></pagination-component>
          </div>
        </div>
      </div>
    </template>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>
<script lang="ts" setup>
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {onMounted, ref} from "vue"
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import {useModal} from "@/composables/useModal"
import {config} from "@/config";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import FlashMessage from "@/components/System/FlashMessage.vue";
import EditIcon from "@/components/Icons/EditIcon.vue";
import DeleteIcon from "@/components/Icons/DeleteIcon.vue";
import SuccessModal from '@/components/Modals/SuccessModal.vue'
import axios from "axios"
import PaginationComponent from "@/components/System/PaginationComponent.vue";

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Проекты',
  'link': '/admin',
  'active': false
}]
const loading = ref(false)
const modal = useModal()
const data = ref([])
const errors = ref(null)
const page = ref(1)

init(bread, false)

onMounted(() => {
  getData()
})

//Functions
async function getData(page = 1) {
  loading.value = true
  await axios.post(config.api_url + 'projects/projectsList', {
    page: page,
  })
    .then((response) => {
      data.value = response.data.data;
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

function removeItemModal(id: number) {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Вы действительно хотите удалить данный объект?',
      subTitle: 'Вы уверены?',
      function: async () => {
        await removeItem(id)
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

async function removeItem(id: number) {
  await axios.get(config.api_url + 'projects/remove/' + id)
    .then(() => {
      getData();
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    });
}

</script>
<style scoped>
</style>
