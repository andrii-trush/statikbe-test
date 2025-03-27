<script setup>
import VueApexCharts from "vue3-apexcharts";
import {Head, useForm, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

import VueTailwindDatepicker from "vue-tailwind-datepicker";
import {computed, ref} from "vue";
import dayjs from "dayjs";

const form = useForm({
  range: [
    usePage().props.start_date,
    usePage().props.end_date,
  ]
})

const datePickerFormatter = ref({
  date: 'YYYY-MM-DD',
  month: 'MMM'
})

const onSelect = () => form.transform((data) => ({
  'start_date': data.range[0],
  'end_date': data.range[1],
})).get(route('statistic'))

const formatedDate = computed(() => {
  if (!form.range[0]) {
    return null;
  }

  return dayjs(form.range[0]).format('DD/MM/YYYY') + ' - ' + dayjs(form.range[1]).format('DD/MM/YYYY');
})
</script>

<template>
  <Head title="Welcome"/>
  <AppLayout>

    <div
        class="flex flex-col items-start gap-6 overflow-hidden max-w-screen-md mx-auto rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
    >
      <VueTailwindDatepicker
          v-model="form.range"
          :formatter="datePickerFormatter"
          @update:model-value="onSelect"
      >
        <input
            readonly
            :value="formatedDate"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            placeholder="DD/MM/YYYY"
        />
      </VueTailwindDatepicker>


      <div class="relative overflow-hidden h-0 pt-[75%] w-full">
        <div class="absolute h-full w-full top-0 left-0">
          <VueApexCharts
              height="100%"
              type="line"
              :series="$page.props.series"
              :options="$page.props.options"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
