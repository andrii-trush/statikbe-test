<script setup>
import {Head} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <Head title="Welcome"/>
  <AppLayout>
    <div
        class="flex flex-col items-start gap-6 overflow-hidden max-w-screen-md mx-auto rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10"
    >
      <p>Booking date: {{ $page.props.booking.booking_date}}</p>
      <p>Booking time: {{ $page.props.booking.booking_start_at}} - {{ $page.props.booking.booking_end_at}}</p>
      <p>Visitors</p>
      <template v-for="visitor in $page.props.booking.visitors">
        <p>{{visitor.first_name}} {{visitor.last_name}} <span v-if="visitor.abonnement_number">({{visitor.abonnement_number}})</span></p>
      </template>
    </div>
  </AppLayout>
</template>
