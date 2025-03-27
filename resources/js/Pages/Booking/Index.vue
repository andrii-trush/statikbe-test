<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

import VueTailwindDatepicker from "vue-tailwind-datepicker";
import {computed, ref} from "vue";
import dayjs from "dayjs";

const form = useForm({
  booking_date: '',
  time_slot: '10:00-12:00',
  visitors: [{
    first_name: '',
    last_name: '',
    abonnement_number: ''
  }]
})

const datePickerFormatter = ref({
  date: 'YYYY-MM-DD',
  month: 'MMM'
})

const canAddVisitors = computed(() => form.visitors.length <= 3)

const onAddVisitor = () => form.visitors.push({
  first_name: '',
  last_name: '',
  abonnement_number: ''
})

const onSubmit = () => form.post(route('booking.store'))

const  formatedDate = computed(() => {
  if(!form.booking_date) {
    return null;
  }

  return dayjs(form.booking_date).format('DD/MM/YYYY');
})
</script>

<template>
  <Head title="Welcome"/>
  <AppLayout>

    <div
        class="flex flex-col items-start gap-6 overflow-hidden max-w-screen-md mx-auto rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
    >
      <form @submit.prevent="onSubmit" class="block w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="col-span-1">
            <label for="booking_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Datum<sup
                class="asterisk">*</sup></label>
            <VueTailwindDatepicker
                required
                v-model="form.booking_date"
                as-single
                :start-from="new Date()"
                :formatter="datePickerFormatter"
            >
              <input
                  readonly
                  :value="formatedDate"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                  placeholder="DD/MM/YYYY"
              />
            </VueTailwindDatepicker>
          </div>
          <div class="col-span-1">
            <label for="time_slot" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tijdslot<sup
                class="asterisk">*</sup></label>
            <select id="time_slot"
                    required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option value="10:00-12:00">10:00 - 12:00</option>
              <option value="12:00-14:00">12:00 - 14:00</option>
              <option value="14:00-16:00">14:00 - 16:00</option>
              <option value="16:00-18:00">16:00 - 18:00</option>
              <option value="18:00-20:00">18:00 - 20:00</option>
            </select>
          </div>
        </div>
        <fieldset class="block w-full mt-6">
          <legend>Bezoekers</legend>
          <template v-for="(visitor, index) in form.visitors">
            <div class="relative mt-4">
              <hr v-if="index > 0" class="my-4"/>
              <div class="grid grid-cols-1 gap-4">
                <div>
                  <label :for="`first_name_${index}`"
                         class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Voornaam
                    <sup class="asterisk">*</sup></label>
                  <input
                      v-model="form.visitors[index].first_name"
                      type="text" :id="`first_name_${index}`"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                      required
                  />
                </div>

                <div>
                  <label :for="`last_name_${index}`"
                         class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Familienaam
                    <sup class="asterisk">*</sup></label>
                  <input
                      v-model="form.visitors[index].last_name"
                      type="text" :id="`last_name_${index}`"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                      required
                  />
                </div>

                <div>
                  <label :for="`last_name_${index}`"
                         class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Abonnementsnummer</label>
                  <input
                      v-model="form.visitors[index].abonnement_number"
                      type="text" :id="`abonnement_number_${index}`"
                      placeholder="1234-5678-90"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  />
                </div>
              </div>
            </div>
          </template>
        </fieldset>
        <div class="flex flex-row justify-end space-x-4 mt-4">
          <button type="button"
                  :disabled="!canAddVisitors"
                  class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 cursor-pointer disabled:cursor-not-allowed"
                  @click="onAddVisitor">Voeg nog een bezoeker toe
          </button>
          <button
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
            Reserveer!
          </button>

        </div>
      </form>
    </div>
  </AppLayout>
</template>
