<script setup lang="ts">
import { Icon } from '@iconify/vue';

const props = defineProps({
  labelName: {
    type: String,
    required: true
  },
  color: {
    type: String,
    default: 'black'
  },
  type: {
    type: String,
    default: "text"
  }
})
</script>
<template lang="pug">
div(class="conatiner relative leading-[80px]")
  input(:type="type" class="px-8 outline-none relative w-fit text-black bg-transparent duration-100 z-[9999]" required)
  p(class="labelInput z-0 text-lg text-gray-400 px-2 absolute top-7 duration-300 whitespace-pre") {{ props.labelName }}
  Icon(icon="ri:eye-off-line" class="IconColor absolute end-4 top-6 text-3xl z-[999999] cursor-pointer")
</template>
<style scoped>
input:focus {
  border: 2px solid v-bind(color);
  border-radius: 6px;
}

.IconColor {
  color: v-bind(color);
}


input{
  border-bottom: 2px solid v-bind(color);
}

.labelInput{
 word-spacing: pre-line;

}

input:focus + .container
{
  border: none;
}

input:focus+.labelInput,
input:valid+.labelInput {
  transform: translate(10px, -40px) scale(0.88);
  z-index: 99999;
  background-color: white;
  color: v-bind(color);
}
</style>