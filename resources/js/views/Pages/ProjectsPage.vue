<template>
  <admin-panel>
      <!--      <flash-message type="success" class="mb-2"></flash-message>-->
      <!--      <h1 class="bd-title">Баннеры</h1>-->
      <!--      <div class="row">-->
      <!--        <div class="col-6 col-lg-2">-->
      <!--          <router-link class="btn btn-primary btn-sm w-100" :to="{name: 'CreateBannerForm'}" title="Добавить">-->
      <!--            <i class="fas fa-plus me-1"></i>-->
      <!--            Добавить-->
      <!--          </router-link>-->
      <!--        </div>-->
      <!--      </div>-->
      <!--      <div class="row mt-4" v-if="!loading">-->
      <!--        <div class="col-lg-8">-->
      <!--          <div class="parts-wrapper">-->
      <!--            <table class="table table-parts table-sm table-bordered table-hover">-->
      <!--              <thead class="table-light">-->
      <!--              <tr>-->
      <!--                <th scope="col">ID</th>-->
      <!--                <th scope="col">Название</th>-->
      <!--                <th scope="col">Создан</th>-->
      <!--                <th scope="col">Изменен</th>-->
      <!--                <th scope="col">Действия</th>-->
      <!--              </tr>-->
      <!--              </thead>-->
      <!--              <tbody class="parts table-group-divider">-->
      <!--              <template v-if="this.data.length > 0">-->
      <!--                <tr v-for="(object,index) in this.data" :key="index">-->
      <!--                  <td>{{ object.id }}</td>-->
      <!--                  <td>{{ object.name }}</td>-->
      <!--                  <td>{{ getDate(object.created_at) }}</td>-->
      <!--                  <td>{{ getDate(object.updated_at) }}</td>-->
      <!--                  <td>-->
      <!--                    <router-link class="me-2" :to="{name: 'EditBannerForm', params: {id: object.id}}" title="Редактировть">-->
      <!--                      <edit-icon class="move-icon"></edit-icon>-->
      <!--                    </router-link>-->
      <!--                    <a href="#" title="Удалить" @click.prevent="removeItem(object.id)">-->
      <!--                      <delete-icon class="move-icon"></delete-icon>-->
      <!--                    </a>-->
      <!--                  </td>-->
      <!--                </tr>-->
      <!--              </template>-->
      <!--              <template v-else>-->
      <!--                <tr>-->
      <!--                  <td colspan="7">-->
      <!--                    Баннеры не найдены-->
      <!--                  </td>-->
      <!--                </tr>-->
      <!--              </template>-->
      <!--              </tbody>-->
      <!--            </table>-->
      <!--            <pagination-component :paginated="data" :current-page="page" @updateList="updateObjectsList"></pagination-component>-->
      <!--          </div>-->
      <!--        </div>-->
      <!--      </div>-->
      <!--      <loading-component v-else></loading-component>-->
  </admin-panel>
</template>

<script lang="ts" setup>
// import BreadcrumbComponent from '@/components/BreadcrumbComponent.vue'
// import FlashMessage from "@/components/FlashMessage.vue";
// import PaginationComponent from "@/components/PaginationComponent.vue";
// import axios from "axios";
// import {flashMessages} from "@/stores/flashMessages";
// import EditIcon from "@/components/icons/EditIcon.vue";
// import DeleteIcon from "@/components/icons/DeleteIcon.vue";
// import LoadingComponent from "@/components/LoadingComponent.vue";
// import {pageMetaStore} from "@/stores/pageMetaStore";
//
// export default {
//   components: {DeleteIcon, EditIcon, AdminPanel, BreadcrumbComponent, FlashMessage, PaginationComponent, LoadingComponent},
//   name: "BannerList",
//   setup() {
//     const pageMeta = pageMetaStore();
//     return {pageMeta};
//   },
//   data() {
//     return {
//       data: [],
//       loading: true,
//       page: 1,
//       update: 0,
//       selects: [],
//       updateForm: 0,
//       breadcrumbs: [{
//         'name': 'Баннеры главная',
//         'link': '/admin/banners',
//         'active': false
//       }],
//     }
//   },
//   mounted() {
//     this.getObjectsList();
//     this.pageMeta.setTitle('Баннеры');
//   },
//   methods: {
//     getObjectsList(page = 1) {
//       axios.post('/admin/banners/bannersList', {
//         page: page,
//       })
//         .then((response) => {
//           this.data = response.data.data;
//         })
//         .catch((error) => {
//           if (error) {
//             this.error = error.response;
//             console.log(error);
//           } else {
//             alert('An error has occurred');
//           }
//         })
//         .finally(() => {
//           this.loading = false;
//         });
//     },
//     updateObjectsList(data: any) {
//       this.getObjectsList(data);
//     },
//     removeItem(id: number) {
//       if (confirm('Вы действительно хотите удалить данный объект?')) {
//         const messages = flashMessages();
//         axios.get('/admin/banners/remove/' + id)
//           .then(() => {
//             this.getObjectsList();
//             messages.addMessage('Объект удален!', 'success');
//             this.update++;
//             this.loading = false;
//           })
//           .catch((error) => {
//             if (error) {
//               this.error = error.response;
//               console.log(error);
//             } else {
//               alert('An error has occurred');
//             }
//             this.loading = false;
//           });
//       }
//     },
//     getDate(data: any) {
//       let date = new Date(data);
//       return date.toLocaleString("ru");
//     }
//   }
// }
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Проекты',
  'link': '/admin',
  'active': false
}]
init(bread, false)
</script>
