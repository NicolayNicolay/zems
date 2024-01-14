<template>
  <admin-panel>
    <div v-if="!loading">
      <h1 class="bd-title" id="title">{{ title }}</h1>
      <div class="row">
        <div class="col-lg-6 col-12">
          <display-errors v-if="errors" :errors="errors"></display-errors>
          <form @submit.prevent="submitForm()">
            <div class="card">
              <div class="card-body add-form">
                <div class="row">
                  <div class="col-lg-12" v-for="(field,indexField) in form" :key="indexField">
                    <div class="row">
                      <div class="col-12 mb-3" v-if="field.id && field.type !== 'textHidden'">
                        <label :for="field.id" class="form-label">{{ field.label }}</label>
                        <input-text-component
                          v-if="field.type === 'text'"
                          :name="field.name"
                          :id="field.id"
                          v-model="field.value"
                          class="form-control"
                        ></input-text-component>
                        <textarea-component
                          v-if="field.type === 'textarea'"
                          :name="field.name"
                          :rows="8"
                          :id="field.id"
                          v-model="field.value"
                          class="form-control"
                        ></textarea-component>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button class="btn btn-primary" @click.prevent="submitForm">Сохранить</button>
                <button class="btn btn-light ms-2" @click="$router.back()">Назад</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>

<script lang="ts" setup>
import axios from "axios";
import {flashMessages} from "@/stores/flashMessagesStore";
import {onMounted, ref} from "vue"
import {useRoute, useRouter} from 'vue-router';
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import {config} from "@/config";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import DisplayErrors from "@/components/System/DisplayErrors.vue";
import InputTextComponent from "@/components/Forms/InputTextComponent.vue";
import TextareaComponent from "@/components/Forms/TextAreaComponent.vue";

const token = ref(null)
const loading = ref(true)
const form = ref([])
const title = ref('')
const objectId = ref(0)
const type = ref('')
const action = ref('')
const errors = ref(null)
const route = useRoute();
const router = useRouter();
const {init} = useBreadcrumbs()
const bread = ref([
  {
    'name': 'Проекты',
    'link': '/admin',
    'active': true
  },
  {
    'name': 'Добавить проект',
    'link': '#',
    'active': false
  }])

init(bread.value);

onMounted(() => {
  let tokenPage = document.head.querySelector('meta[name="csrf-token"]');
  if (tokenPage) {
    token.value = ref(tokenPage.content)
  }
  getForm();
})

async function getForm() {
  loading.value = true;
  console.log(route.params);
  if (route.params && route.params.id) {
    objectId.value = Number(route.params.id);
  }
  await axios.get(config.api_url + 'projects/get_form' + (objectId.value ? '/' + objectId.value : ''))
    .then((response) => {
      action.value = response.data.action;
      title.value = response.data.title;
      bread.value[1].name = response.data.title;
      type.value = response.data.type;
      form.value = response.data.form;
      errors.value = null;
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

/**
 * Отправка формы
 */
function submitForm() {
  loading.value = true;
  const messages = flashMessages();
  axios.post(action.value, form.value)
    .then(() => {
      if (type.value === 'edit') {
        errors.value = null;
        messages.addMessage('Проект обновлен', 'success');
      } else {
        messages.addMessage('Проект добавлен', 'success');
      }
      router.push({name: 'ProjectsPage'})
    })
    .catch((error) => {
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
        setTimeout(() => {
          let validationMessages = document.getElementById('title');
          if (validationMessages) {
            validationMessages.scrollIntoView({block: "center", behavior: "smooth"});
          }
        }, 300);
      }
    })
    .finally(() => {
      loading.value = false;
    });
}

</script>
