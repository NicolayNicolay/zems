<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useModal} from '@/composables/useModal'
import InputTextComponent from "@/components/Forms/InputTextComponent.vue";
import TextareaComponent from "@/components/Forms/TextAreaComponent.vue";
import {config} from "@/config";

const {params, close} = useModal()

const errors = ref(null)
const workStatus = ref(false)
const makeUser = ref('')
const endWork = ref(false)
const endWorkTime = ref('')
const readyWork = ref(false)

onMounted(() => {
  if (params.modelValue.element && params.modelValue.element.id) {
    readyWork.value = true
  }
  if (params.modelValue.element && params.modelValue.element.make_user_id) {
    workStatus.value = !!params.modelValue.element.make_user_id
    makeUser.value = params.modelValue.element.make_user_data.name
    if (params.modelValue.element.end) {
      endWork.value = true
      endWorkTime.value = params.modelValue.element.end
    }
  }
})


const form = ref({
  'id': 0,
  'name': '',
  'description': '',
  'project_id': params.modelValue.project_id
})

if (params.modelValue.element) {
  form.value.id = params.modelValue.element.id;
  form.value.name = params.modelValue.element.name;
  form.value.description = params.modelValue.element.description;
}

/**
 * Отправка формы
 */
function submitForm() {
  axios.post(config.api_url + 'tasks/store', form.value)
    .then(() => {
      close()
      params.modelValue.reloadFunction()
    })
    .catch((error) => {
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
      }
    })
}

function startTask() {
  axios.post(config.api_url + 'tasks/startTask', form.value)
    .then((response) => {
      if (!response.data.status) {
        errors.value = response.data.error
      } else {
        close()
        params.modelValue.reloadFunction()
      }
    });
}

function endTask() {
  axios.post(config.api_url + 'tasks/endTask', form.value)
    .then((response) => {
      if (response.data.status) {
        close()
        params.modelValue.reloadFunction()
      } else {
        errors.value = response.data.error
      }
    });
}
</script>

<template>
  <div class="modal-body pt-3 pb-3 text-center">
    <div class="alert alert-danger" id="validation-messages" v-if="errors">
      {{ errors }}
    </div>
    <form @submit.prevent="submitForm()">
      <div class="card">
        <div class="card-body add-form">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-start mb-3">
                <label for="name" class="form-label">Название</label>
                <input-text-component
                  name="name"
                  id="name"
                  v-model="form.name"
                  class="form-control"
                ></input-text-component>
              </div>
              <div class="text-start mb-3">
                <label for="name" class="form-label">Описание задачи</label>
                <textarea-component
                  name="description"
                  id="description"
                  :rows="12"
                  :cols="200"
                  v-model="form.description"
                  class="form-control"
                ></textarea-component>
              </div>
              <template v-if="readyWork">
                <template v-if="!endWork">
                  <div class="text-start mb-3" v-if="!workStatus">
                    <a href="#" @click.prevent="startTask">
                      Взять в работу
                    </a>
                  </div>
                  <div class="text-start mb-3" v-else>
                    <div>Взял в работу: {{ makeUser }}</div>
                    <a href="#" @click.prevent="endTask">
                      Закончить работу
                    </a>
                  </div>
                </template>
                <div class="text-start mb-3" v-else>
                  <div>
                    Задачу выполнил: {{ makeUser }}
                  </div>
                  <div>
                    Конец выполнения: {{ endWorkTime }}
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" @click.prevent="submitForm">Сохранить</button>
          <button class="btn btn-light ms-2" @click.prevent="close">Закрыть</button>
        </div>
      </div>
    </form>
  </div>
</template>
<style scoped lang="scss">
.btn {
  --bs-btn-padding-x: 2rem;
}
</style>
